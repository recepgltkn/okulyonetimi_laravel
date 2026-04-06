import 'dotenv/config';
import express from 'express';
import cors from 'cors';
import { createServer } from 'node:http';
import { Server } from 'socket.io';
import { buildSocketHandlers } from './socket.js';
import { redisChannel, redisSubscriber } from './redis.js';

const app = express();
app.use(cors({ origin: process.env.CORS_ORIGIN?.split(',') || '*' }));
app.use(express.json({ limit: '1mb' }));

app.get('/health', (_, res) => {
  res.json({ ok: true, service: 'keyboard-race-socket' });
});

const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: process.env.CORS_ORIGIN?.split(',') || '*',
    methods: ['GET', 'POST'],
  },
  pingInterval: 25000,
  pingTimeout: 20000,
});

const handlers = buildSocketHandlers(io);

redisSubscriber.subscribe(redisChannel, (err) => {
  if (err) {
    console.error('Redis subscribe error:', err.message);
  } else {
    console.log(`Redis subscribed: ${redisChannel}`);
  }
});

redisSubscriber.on('message', (_channel, rawMessage) => {
  try {
    const message = JSON.parse(rawMessage);
    handlers.relayRedisEvent(message);
  } catch (error) {
    console.error('Invalid redis payload', error);
  }
});

const port = Number(process.env.PORT || 3001);
httpServer.listen(port, () => {
  console.log(`Socket server running on :${port}`);
});

function shutdown() {
  Promise.allSettled([redisSubscriber.quit()]).finally(() => {
    io.close();
    httpServer.close(() => process.exit(0));
  });
}

process.on('SIGINT', shutdown);
process.on('SIGTERM', shutdown);
