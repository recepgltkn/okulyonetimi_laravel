function toSafeNumber(value, fallback = 0) {
  const n = Number(value);
  return Number.isFinite(n) ? n : fallback;
}

export function buildSocketHandlers(io) {
  const roomState = new Map();

  const getOrCreate = (roomCode) => {
    if (!roomState.has(roomCode)) {
      roomState.set(roomCode, {
        started: false,
        participants: new Set(),
        sockets: new Set(),
      });
    }

    return roomState.get(roomCode);
  };

  io.on('connection', (socket) => {
    socket.on('join_room', (payload = {}) => {
      const roomCode = String(payload.roomCode || '').trim().toUpperCase();
      const userName = String(payload.userName || '').trim();
      if (!roomCode || !userName) return;

      socket.data.roomCode = roomCode;
      socket.data.userName = userName;

      socket.join(roomCode);
      const room = getOrCreate(roomCode);
      room.sockets.add(socket.id);

      const spectator = room.started && !room.participants.has(userName);
      if (!spectator) {
        room.participants.add(userName);
      }

      socket.emit('room_joined', { roomCode, spectator });
      socket.to(roomCode).emit('room_presence', {
        userName,
        spectator,
        progress: 0,
        wpm: 0,
        accuracy: 100,
      });
    });

    socket.on('start_race', (payload = {}) => {
      const roomCode = String(payload.roomCode || socket.data.roomCode || '').toUpperCase();
      if (!roomCode) return;
      io.to(roomCode).emit('start_race', payload);
    });

    socket.on('typing_progress', (payload = {}) => {
      const roomCode = String(payload.roomCode || socket.data.roomCode || '').toUpperCase();
      const userName = String(payload.userName || socket.data.userName || '').trim();
      if (!roomCode || !userName) return;

      socket.to(roomCode).emit('typing_progress', {
        userName,
        progress: toSafeNumber(payload.progress),
        wpm: toSafeNumber(payload.wpm),
        accuracy: toSafeNumber(payload.accuracy, 100),
      });
    });

    socket.on('finish_race', (payload = {}) => {
      const roomCode = String(payload.roomCode || socket.data.roomCode || '').toUpperCase();
      const userName = String(payload.userName || socket.data.userName || '').trim();
      if (!roomCode || !userName) return;

      socket.to(roomCode).emit('finish_race', {
        userName,
        progress: toSafeNumber(payload.progress, 100),
        wpm: toSafeNumber(payload.wpm),
        accuracy: toSafeNumber(payload.accuracy, 100),
      });
    });

    socket.on('disconnect', () => {
      const roomCode = socket.data.roomCode;
      if (!roomCode) return;
      const room = roomState.get(roomCode);
      if (!room) return;

      room.sockets.delete(socket.id);
      if (room.sockets.size === 0 && !room.started) {
        roomState.delete(roomCode);
      }
    });
  });

  return {
    relayRedisEvent(message) {
      const roomCode = String(message.roomCode || '').toUpperCase();
      if (!roomCode) return;

      const payload = message.payload || {};
      const room = getOrCreate(roomCode);

      switch (message.type) {
        case 'race_started': {
          room.started = true;
          const participants = Array.isArray(payload.participants) ? payload.participants : [];
          room.participants = new Set(participants.map((p) => p.userName).filter(Boolean));
          io.to(roomCode).emit('race_started', payload);
          break;
        }
        case 'race_finished': {
          io.to(roomCode).emit('race_finished', payload);
          room.started = false;
          break;
        }
        case 'user_joined': {
          io.to(roomCode).emit('room_presence', {
            userName: payload.userName,
            spectator: !!payload.spectator,
            progress: 0,
            wpm: 0,
            accuracy: 100,
          });
          break;
        }
        case 'room_created':
        default:
          io.to(roomCode).emit(message.type, payload);
      }
    },
  };
}
