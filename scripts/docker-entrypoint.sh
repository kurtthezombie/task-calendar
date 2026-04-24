#!/bin/sh
set -e

attempt=1
until npx prisma db push; do
  if [ "$attempt" -ge 30 ]; then
    echo "Database did not become ready after $attempt attempts."
    exit 1
  fi

  echo "Waiting for database... attempt $attempt"
  attempt=$((attempt + 1))
  sleep 2
done

npx prisma db seed
node server.js
