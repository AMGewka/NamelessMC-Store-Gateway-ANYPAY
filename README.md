# AnyPay Gateway Integration for NamelessMC Store

This module integrates the [AnyPay](https://anypay.io) payment gateway into the NamelessMC Store module. It supports secure redirect payments, API balance checking, and full order tracking.

---

## 🛡️ Security

- Uses SHA256 signature in format:  
  `sha256(shop_id:amount:secret:order_id)`
- Callback is verified by rebuilding the same hash server-side
- API key is used for authenticated balance and transaction queries

---

## ⚙️ Functionality Overview

### ✅ Payment Acceptance

- Payments are performed via redirect to `https://anypay.io/merchant`
- Required fields:
    - `merchant_id`
    - `amount`
    - `order_id`
    - `sign` (sha256 hash)
    - `currency` (optional)
    - `success_url`, `fail_url`, `email`
- Callback (pingback) is received as POST
- Signature is verified using secret word

### 💰 Balance Check (Optional)

- Uses API endpoint: `https://anypay.io/api/balance`
- Requires:
    - `X-Api-Id` header
    - `X-Api-Key` header
- Returns wallet balances per currency (RUB, USD, USDT, etc.)

---

## 🌐 Supported Currencies

- RUB, USD, EUR, USDT, BTC
- More currencies may be available per merchant account

---

## 🧱 API Architecture

- Payment: browser redirect with GET parameters
- Callback: POST request with hash verification
- Balance: JSON over HTTP GET + headers

---

## 🧩 NamelessMC Store Compatibility

- Fully supports Store v1.8.3+
- Utilizes:
    - `GatewayBase`, `StoreConfig`, `Order`, `URL`, `Language`
    - `curl`, `Token::check`, `Session::flash`, `DB::update`
- Admin UI through `settings.tpl`
- Multi-language: Russian, English, Ukrainian

---

## ⚠️ Limitations

- No support for recurring payments
- No partial refunds or invoice API
- Currency support may depend on merchant plan

---

## 🔗 Documentation

- [AnyPay Merchant Docs](https://anypay.io/doc/sci)
- [AnyPay API Docs](https://anypay.io/doc/api)
- [NamelessMC Store](https://github.com/partydragen/Nameless-Store)
