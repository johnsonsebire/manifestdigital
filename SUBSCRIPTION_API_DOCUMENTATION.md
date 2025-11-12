# Subscription Management API Documentation

## Overview

The Subscription Management API provides programmatic access to subscription data and operations. All endpoints are RESTful and return JSON responses.

**Base URL:** `https://your-domain.com/api/v1`

**Version:** 1.0

## Authentication

All API endpoints require authentication using Laravel Sanctum tokens.

### Getting an API Token

```bash
POST /api/v1/auth/token
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

### Using the Token

Include the token in the Authorization header:

```bash
Authorization: Bearer {your-token}
```

## Rate Limiting

- **Rate Limit:** 60 requests per minute per user
- **Headers:**
  - `X-RateLimit-Limit`: Maximum requests allowed
  - `X-RateLimit-Remaining`: Remaining requests
  - `Retry-After`: Seconds until limit resets (when limit exceeded)

## Response Format

### Success Response

```json
{
  "success": true,
  "data": { ... },
  "meta": { ... },
  "links": { ... }
}
```

### Error Response

```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["validation error"]
  }
}
```

## HTTP Status Codes

- `200 OK`: Request succeeded
- `201 Created`: Resource created successfully
- `400 Bad Request`: Invalid request parameters
- `401 Unauthorized`: Missing or invalid authentication
- `403 Forbidden`: Insufficient permissions
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation failed
- `429 Too Many Requests`: Rate limit exceeded
- `500 Internal Server Error`: Server error

---

## Endpoints

### 1. List Subscriptions

Get a paginated list of subscriptions with filtering and sorting.

**Endpoint:** `GET /api/v1/subscriptions`

**Parameters:**

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `per_page` | integer | Items per page (max 100) | `15` |
| `page` | integer | Page number | `1` |
| `status` | string | Filter by status (comma-separated) | `active,trial` |
| `customer_id` | integer | Filter by customer ID | `123` |
| `service_id` | integer | Filter by service ID | `456` |
| `auto_renew` | boolean | Filter by auto-renew status | `true` |
| `expires_after` | date | Filter by expiration date (after) | `2025-01-01` |
| `expires_before` | date | Filter by expiration date (before) | `2025-12-31` |
| `created_after` | date | Filter by creation date (after) | `2025-01-01` |
| `search` | string | Search by UUID, customer, or service | `john` |
| `sort_by` | string | Sort field | `created_at` |
| `sort_order` | string | Sort direction (`asc`/`desc`) | `desc` |

**Example Request:**

```bash
GET /api/v1/subscriptions?status=active&per_page=20&sort_by=expires_at&sort_order=asc
Authorization: Bearer {token}
```

**Example Response:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "uuid": "550e8400-e29b-41d4-a716-446655440000",
      "status": "active",
      "billing_interval": "monthly",
      "auto_renew": true,
      "starts_at": "2025-01-01T00:00:00Z",
      "expires_at": "2025-02-01T00:00:00Z",
      "trial_ends_at": null,
      "cancelled_at": null,
      "created_at": "2025-01-01T00:00:00Z",
      "updated_at": "2025-01-01T00:00:00Z",
      "renewal_price": 29.99,
      "renewal_discount_percentage": 10.0,
      "days_until_expiration": 12,
      "is_active": true,
      "is_expired": false,
      "service": {
        "id": 1,
        "name": "Premium Web Hosting",
        "description": "High-performance hosting",
        "price": 29.99
      },
      "customer": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      },
      "order": {
        "id": 1,
        "uuid": "order-12345",
        "status": "completed",
        "total_amount": 29.99
      },
      "metadata": {},
      "cancellation_reason": null,
      "custom_billing_terms": null
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72,
    "from": 1,
    "to": 15
  },
  "links": {
    "first": "https://your-domain.com/api/v1/subscriptions?page=1",
    "last": "https://your-domain.com/api/v1/subscriptions?page=5",
    "prev": null,
    "next": "https://your-domain.com/api/v1/subscriptions?page=2"
  }
}
```

---

### 2. Get Subscription

Retrieve a single subscription by UUID.

**Endpoint:** `GET /api/v1/subscriptions/{uuid}`

**Example Request:**

```bash
GET /api/v1/subscriptions/550e8400-e29b-41d4-a716-446655440000
Authorization: Bearer {token}
```

**Example Response:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "status": "active",
    ...
  }
}
```

---

### 3. Create Subscription

Create a new subscription.

**Endpoint:** `POST /api/v1/subscriptions`

**Request Body:**

```json
{
  "customer_id": 123,
  "service_id": 456,
  "billing_interval": "monthly",
  "starts_at": "2025-01-01",
  "expires_at": "2025-02-01",
  "auto_renew": true,
  "trial_ends_at": null,
  "renewal_price": 29.99,
  "renewal_discount_percentage": 10,
  "metadata": {
    "custom_field": "value"
  }
}
```

**Validation Rules:**

- `customer_id`: required, must exist
- `service_id`: required, must exist
- `billing_interval`: required, must be `monthly` or `yearly`
- `starts_at`: required, valid date
- `expires_at`: required, valid date, must be after `starts_at`
- `auto_renew`: optional, boolean
- `trial_ends_at`: optional, valid date
- `renewal_price`: optional, numeric, minimum 0
- `renewal_discount_percentage`: optional, numeric, 0-100
- `metadata`: optional, array

**Example Response:**

```json
{
  "success": true,
  "message": "Subscription created successfully",
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    ...
  }
}
```

**Status Code:** `201 Created`

---

### 4. Update Subscription

Update an existing subscription.

**Endpoint:** `PUT /api/v1/subscriptions/{uuid}` or `PATCH /api/v1/subscriptions/{uuid}`

**Request Body:**

```json
{
  "status": "active",
  "expires_at": "2025-03-01",
  "auto_renew": false,
  "renewal_price": 24.99,
  "renewal_discount_percentage": 15,
  "metadata": {
    "updated_field": "new_value"
  }
}
```

**Validation Rules:**

- `status`: optional, must be valid status
- `expires_at`: optional, valid date
- `auto_renew`: optional, boolean
- `renewal_price`: optional, numeric, minimum 0
- `renewal_discount_percentage`: optional, numeric, 0-100
- `metadata`: optional, array

**Example Response:**

```json
{
  "success": true,
  "message": "Subscription updated successfully",
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    ...
  }
}
```

---

### 5. Cancel Subscription

Cancel an existing subscription.

**Endpoint:** `DELETE /api/v1/subscriptions/{uuid}`

**Example Request:**

```bash
DELETE /api/v1/subscriptions/550e8400-e29b-41d4-a716-446655440000
Authorization: Bearer {token}
```

**Example Response:**

```json
{
  "success": true,
  "message": "Subscription cancelled successfully",
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "status": "cancelled",
    "cancelled_at": "2025-01-20T12:00:00Z",
    ...
  }
}
```

---

### 6. Renew Subscription

Renew a subscription by extending the expiration date.

**Endpoint:** `POST /api/v1/subscriptions/{uuid}/renew`

**Request Body:**

```json
{
  "duration_months": 12,
  "payment_method": "card"
}
```

**Validation Rules:**

- `duration_months`: optional, integer, 1-36 (defaults to billing interval)
- `payment_method`: optional, string

**Example Response:**

```json
{
  "success": true,
  "message": "Subscription renewed successfully",
  "data": {
    "id": 1,
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "expires_at": "2026-01-20T00:00:00Z",
    "status": "active",
    ...
  }
}
```

---

### 7. Get Statistics

Get subscription statistics summary.

**Endpoint:** `GET /api/v1/subscriptions/stats`

**Example Request:**

```bash
GET /api/v1/subscriptions/stats
Authorization: Bearer {token}
```

**Example Response:**

```json
{
  "success": true,
  "data": {
    "total": 150,
    "active": 120,
    "trial": 10,
    "expired": 5,
    "cancelled": 10,
    "suspended": 3,
    "pending_renewal": 2,
    "expiring_soon": 15
  }
}
```

---

## Status Values

| Status | Description |
|--------|-------------|
| `active` | Subscription is currently active |
| `trial` | Subscription is in trial period |
| `expired` | Subscription has expired |
| `cancelled` | Subscription was cancelled |
| `suspended` | Subscription is suspended |
| `pending_renewal` | Subscription is pending renewal |

## Billing Intervals

| Interval | Description |
|----------|-------------|
| `monthly` | Billed monthly |
| `yearly` | Billed annually |

---

## Code Examples

### PHP (Laravel)

```php
use Illuminate\Support\Facades\Http;

$response = Http::withToken($token)
    ->get('https://your-domain.com/api/v1/subscriptions', [
        'status' => 'active',
        'per_page' => 20,
    ]);

$subscriptions = $response->json('data');
```

### JavaScript (Axios)

```javascript
const axios = require('axios');

const response = await axios.get('https://your-domain.com/api/v1/subscriptions', {
  headers: {
    'Authorization': `Bearer ${token}`
  },
  params: {
    status: 'active',
    per_page: 20
  }
});

const subscriptions = response.data.data;
```

### Python (Requests)

```python
import requests

headers = {'Authorization': f'Bearer {token}'}
params = {'status': 'active', 'per_page': 20}

response = requests.get(
    'https://your-domain.com/api/v1/subscriptions',
    headers=headers,
    params=params
)

subscriptions = response.json()['data']
```

### cURL

```bash
curl -X GET "https://your-domain.com/api/v1/subscriptions?status=active&per_page=20" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

## Webhooks (Coming Soon)

Webhook notifications for subscription events:

- `subscription.created`
- `subscription.updated`
- `subscription.renewed`
- `subscription.cancelled`
- `subscription.expired`

---

## Error Handling

### Validation Error (422)

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "customer_id": ["The customer id field is required."],
    "expires_at": ["The expires at must be a date after starts at."]
  }
}
```

### Not Found (404)

```json
{
  "success": false,
  "message": "Subscription not found"
}
```

### Rate Limit (429)

```json
{
  "success": false,
  "message": "Too many requests"
}
```

Headers:
- `Retry-After: 60`

---

## Best Practices

1. **Always use HTTPS** for API requests
2. **Store tokens securely** - never expose in client-side code
3. **Handle rate limits** - implement exponential backoff
4. **Validate responses** - check `success` field
5. **Use pagination** - don't request all data at once
6. **Cache responses** - where appropriate
7. **Handle errors gracefully** - implement proper error handling
8. **Log API calls** - for debugging and monitoring

---

## Support

For API support, please contact:
- Email: api-support@example.com
- Documentation: https://your-domain.com/docs/api
- Status Page: https://status.your-domain.com
