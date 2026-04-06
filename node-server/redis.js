import Redis from 'ioredis';

const redisConfig = {
  host: process.env.REDIS_HOST || '127.0.0.1',
  port: Number(process.env.REDIS_PORT || 6379),
  password: process.env.REDIS_PASSWORD || undefined,
  maxRetriesPerRequest: null,
  enableReadyCheck: true,
};

export const redisSubscriber = new Redis(redisConfig);
export const redisPublisher = new Redis(redisConfig);

export const redisChannel = process.env.REDIS_CHANNEL || 'race_events';
