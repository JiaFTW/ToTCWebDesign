## Repo snapshot — quick orientation

- Language: PHP (plain PHP pages + small API directory). Frontend pages live in the `frontend/` folder; lightweight backend APIs are under `backend/api/`. Background workers are in `broker/`.
- Key integrations: Stripe (Checkout & charges), RabbitMQ (php-amqplib) for async queues, MySQL for persistence. Environment values are loaded with `vlucas/phpdotenv`.

## High-level architecture (what to know first)

- User flows are session-driven: cart stored in `$_SESSION['cart']`, authenticated identity in `$_SESSION['username']`.
- Payments:
  - Checkout session flow: `backend/api/create_checkout_session.php` converts session cart → Stripe Checkout session.
  - Legacy direct-charge flow (used in places): `backend/api/process_payment.php` creates a Stripe Charge and then enqueues an order to RabbitMQ.
- Queues & workers:
  - Orders are published to the RabbitMQ queue named `orders` (see `backend/api/process_payment.php`).
  - The consumer that persists orders + loyalty points is `broker/order_consumer.php`.
  - Another worker `broker/consumer.php` processes `user_requests` (used for async user registration in this codebase).

## Project-specific conventions & patterns

- Session-first: many pages depend on session variables (cart, csrf_token, username). When modifying checkout flows, always check how sessions are populated in frontend pages (e.g. `cart.php`, `menu.php`).
- Environment: `.env` at repo root is used. Code uses `Dotenv::createImmutable(__DIR__.'/../../')` from `backend/api/*`, so expect the `.env` at repository root. Typical vars referenced in code: `STRIPE_SECRET_KEY`, `APP_DOMAIN`.
- Hard-coded infra credentials exist in repo (RabbitMQ host/credentials and some DB values in broker scripts). Treat these as TODOs to rotate — they are discoverable in `broker/rabbitmq_config.php`, `broker/consumer.php`, and other broker files.
- Database access: `backend/api/database.php` exposes `getDB()` (the consumers and API endpoints use it). Changes to DB schema require coordinated updates in both API and `broker/order_consumer.php` which inserts order items.

## Integration points to check when changing logic

- Stripe keys & webhook URLs: `backend/api/create_checkout_session.php` (Checkout session creation) and `backend/api/stripe_webhook.php` (webhook handling). Update `APP_DOMAIN` in `.env` if changing redirect URLs.
- Message queue names: `orders` and `user_requests`. Producers: `backend/api/process_payment.php` and potentially other API endpoints. Consumers: `broker/order_consumer.php`, `broker/consumer.php`.
- Loyalty points: both `create_checkout_session.php` (test helper) and `broker/order_consumer.php` update `users.loyalty_points` — keep logic consistent.

## Developer workflows (concrete commands)

- Install PHP deps: run `composer install` in the repo root (composer.json lists `php-amqplib`, `stripe-php`, `vlucas/phpdotenv`, `phpmailer`).
- Run web root for quick dev: from repo root run a PHP server pointing to `frontend/`:

  php -S localhost:8000 -t frontend/

- Start consumers (in separate terminals):

  php broker/consumer.php
  php broker/order_consumer.php

- To run the app end-to-end you need a running MySQL instance and RabbitMQ. The repo contains example (hard-coded) RabbitMQ host/credentials in `broker/rabbitmq_config.php`; prefer configuring `.env` and updating those scripts before production.

## Files to open first when debugging a flow

- Checkout creation & redirect: `backend/api/create_checkout_session.php`
- Direct payment + enqueue: `backend/api/process_payment.php`
- Order persistence + loyalty points: `broker/order_consumer.php`
- Worker infra config: `broker/rabbitmq_config.php`, `broker/consumer.php`
- UI entry points: `frontend/cart.php`, `frontend/checkout.php`, `frontend/payment.php`, `frontend/success.php`

## Short examples to copy/paste

- Create a Stripe Checkout session (already implemented): review `backend/api/create_checkout_session.php` — it maps `$_SESSION['cart']` → Stripe line items and uses `$_ENV['STRIPE_SECRET_KEY']`.
- Publish an order to RabbitMQ (already implemented): see `backend/api/process_payment.php` — the code builds `$order` and publishes to queue `orders` using `PhpAmqpLib\\Message\\AMQPMessage`.

## Security and maintenance notes (what the agent should flag)

- Credentials in code: RabbitMQ host/username/password and some DB host/creds are present in broker code. Raise a PR to move these into `.env` and avoid committing secrets.
- Stripe keys: code expects `STRIPE_SECRET_KEY` in `.env`. Test keys may be used in code; verify before running in production.

If anything is unclear or you'd like the file to emphasize different details (for example: local Docker compose steps, DB schema notes, or sensitive-file redaction), tell me what to add and I will iterate.  