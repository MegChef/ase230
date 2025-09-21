---
title: "Test Doc"
date: 2025-09-14T14:34:54-04:00
draft: true
categories: ["documentation"]
tags: ["api", "reference"]
api_version: "v1.0"
weight: 10
---

# Test Doc

## Endpoint Description

What does this endpoint do?

## HTTP Method and URL

```http
GET /api/endpoint
```

## Parameters

| Parameter | Type    | Required | Description |
|-----------|---------|----------|-------------|
| param1    | string  | Yes      | Description |
| param2    | integer | No       | Description |

## Request Example

```bash
curl -X GET "https://api.example.com/endpoint" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

## Response Example

```json
{
  "status": "success",
  "data": {
    "message": "Hello World"
  }
}
```

## Error Responses

| Status Code | Description  |
|-------------|--------------|
| 400         | Bad Request  |
| 401         | Unauthorized |
| 404         | Not Found    |
