# Postman Collection for FAQs CRUD

This collection contains comprehensive tests for FAQs CRUD operations, including both public viewing endpoints and admin management endpoints.

## Files

1. **postman_faqs_collection.json** - Postman collection with all FAQs API endpoints
2. **postman_environment.json** - Environment variables (shared with main collection)

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_faqs_collection.json`
4. The collection will be imported with all FAQs CRUD endpoints

### 2. Import Environment (if not already imported)
1. In Postman, click on **Environments** in the left sidebar
2. Click **Import**
3. Select `postman_environment.json`
4. Select the imported environment from the dropdown (top right)

### 3. Configure Base URL
- The default base URL is set to `http://localhost:8000`
- If your Laravel app runs on a different URL, update the `base_url` variable in the environment

### 4. Get Admin Token (for Admin Endpoints)
Before testing Admin endpoints, you need to:
1. Login as admin using the main authentication collection
2. The `admin_token` will be automatically saved to the environment
3. All Admin endpoints use `{{admin_token}}` for authentication

**Note:** Public endpoints (Get All FAQs, Get FAQ by ID, Search FAQs) do not require authentication.

## Collection Structure

The collection is organized into two main folders:

### Public Endpoints (No Authentication Required)

#### 1. Get All FAQs
- **Method**: GET
- **URL**: `/api/faqs`
- **Query Parameters**:
  - `search` (optional): Search by question_en, question_ar, answer_en, or answer_ar
  - `segment` (optional): Filter by segment - `user`, `origin`, or `individual`
- **Response**: List of FAQs with pagination

#### 2. Get All FAQs - With Filters
- **Method**: GET
- **URL**: `/api/faqs?segment=user`
- **Description**: Example request with segment filter applied

#### 3. Get FAQ by ID
- **Method**: GET
- **URL**: `/api/faqs/{id}`
- **Note**: Requires `faq_id` variable (set automatically when creating a FAQ)

#### 4. Search FAQs
- **Method**: GET
- **URL**: `/api/faqs?search={term}&segment={segment}`
- **Query Parameters**:
  - `search`: Search term (searches in question_en, question_ar, answer_en, answer_ar)
  - `segment`: Filter by segment (user, origin, individual)

### Admin Endpoints (Authentication Required)

#### 1. Create FAQ
- **Method**: POST
- **URL**: `/api/admin/faqs`
- **Authentication**: Bearer token (admin_token)
- **Body**: JSON with the following fields:
  - `question_en` (required): English question
  - `question_ar` (required): Arabic question
  - `answer_en` (required): English answer
  - `answer_ar` (required): Arabic answer
  - `segment` (optional): Segment type - `user`, `origin`, or `individual`
  - `is_active` (optional): Boolean - default: true
- **Auto-saves**: `faq_id` to environment for use in other requests

#### 2. Update FAQ
- **Method**: PUT
- **URL**: `/api/admin/faqs/{id}`
- **Authentication**: Bearer token (admin_token)
- **Body**: JSON (all fields optional):
  - `question_en` (optional): English question
  - `question_ar` (optional): Arabic question
  - `answer_en` (optional): English answer
  - `answer_ar` (optional): Arabic answer
  - `segment` (optional): Segment type - `user`, `origin`, or `individual`
  - `is_active` (optional): Boolean
- **Note**: All fields are optional. You can update one or multiple fields.

#### 3. Update FAQ - Partial Update
- **Method**: PUT
- **URL**: `/api/admin/faqs/{id}`
- **Description**: Example request showing how to update only specific fields (e.g., just is_active)

#### 4. Delete FAQ
- **Method**: DELETE
- **URL**: `/api/admin/faqs/{id}`
- **Authentication**: Bearer token (admin_token)
- **Note**: Requires `faq_id` variable (set automatically when creating a FAQ)

## Testing Flow

### Recommended Testing Order:

1. **First, login as admin (for admin endpoints):**
   - Use the main authentication collection
   - Login as admin to get `admin_token`

2. **Test Public Endpoints:**
   - Get All FAQs
   - Get All FAQs - With Filters
   - Search FAQs
   - Get FAQ by ID (requires faq_id - create a FAQ first or use an existing ID)

3. **Test Admin Endpoints:**
   - Create FAQ (automatically saves `faq_id` to environment)
   - Get FAQ by ID (uses saved `faq_id`)
   - Update FAQ (uses saved `faq_id`)
   - Update FAQ - Partial Update (uses saved `faq_id`)
   - Delete FAQ (uses saved `faq_id`)

## Request Examples

### Create FAQ (JSON)
```json
{
    "question_en": "How do I create an account?",
    "question_ar": "كيف يمكنني إنشاء حساب؟",
    "answer_en": "To create an account, click on the Register button and fill in your details.",
    "answer_ar": "لإنشاء حساب، انقر على زر التسجيل واملأ بياناتك.",
    "segment": "user",
    "is_active": true
}
```

### Update FAQ (JSON - All Fields Optional)
```json
{
    "question_en": "How do I update my account?",
    "is_active": false
}
```

### Update FAQ - Partial (JSON)
```json
{
    "is_active": false
}
```

## Environment Variables

The following variables are used:

- `base_url` - API base URL (default: http://localhost:8000)
- `admin_token` - Admin authentication token (from main auth collection)
- `faq_id` - FAQ ID (automatically saved when creating a FAQ)

## Notes

- **Public vs Admin Endpoints**: Public endpoints (GET) don't require authentication. Admin endpoints (POST, PUT, DELETE) require admin authentication.
- **JSON Format**: Admin endpoints use JSON format (not form-data) since there are no file uploads.
- **FAQ ID**: The `faq_id` is automatically saved to the environment when you create a FAQ, and is used in subsequent requests (Get, Update, Delete).
- **Search**: Search works on both English and Arabic questions and answers.
- **Filtering**: You can filter by `segment` (user, origin, individual).
- **Segment**: The segment field is optional and can be `user`, `origin`, or `individual`. It helps categorize FAQs for different user types.

## Response Examples

### Get All FAQs Response
```json
{
    "message": "FAQs retrieved successfully",
    "data": [
        {
            "id": 1,
            "question_en": "How do I create an account?",
            "question_ar": "كيف يمكنني إنشاء حساب؟",
            "answer_en": "To create an account, click on the Register button and fill in your details.",
            "answer_ar": "لإنشاء حساب، انقر على زر التسجيل واملأ بياناتك.",
            "segment": "user",
            "is_active": true,
            "created_at": "2026-01-22 12:00:00",
            "updated_at": "2026-01-22 12:00:00"
        }
    ],
    "pagination": {
        "total": 1,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "from": 1,
        "to": 1
    }
}
```

### Create FAQ Response
```json
{
    "message": "FAQ created successfully",
    "data": {
        "id": 1,
        "question_en": "How do I create an account?",
        "question_ar": "كيف يمكنني إنشاء حساب؟",
        "answer_en": "To create an account, click on the Register button and fill in your details.",
        "answer_ar": "لإنشاء حساب، انقر على زر التسجيل واملأ بياناتك.",
        "segment": "user",
        "is_active": true,
        "created_at": "2026-01-22 12:00:00",
        "updated_at": "2026-01-22 12:00:00"
    }
}
```

### Delete FAQ Response
```json
{
    "message": "FAQ deleted successfully"
}
```

## Error Responses

### 404 - FAQ Not Found
```json
{
    "message": "FAQ not found"
}
```

### 500 - Server Error
```json
{
    "message": "Failed to [operation] FAQ",
    "error": "Error message details"
}
```

### 401 - Unauthorized (Admin Endpoints)
```json
{
    "message": "Unauthenticated."
}
```

### 422 - Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "question_en": ["The question en field is required."],
        "question_ar": ["The question ar field is required."],
        "answer_en": ["The answer en field is required."],
        "answer_ar": ["The answer ar field is required."]
    }
}
```

## Segment Types

The `segment` field can have one of the following values:
- `user` - For general user FAQs
- `origin` - For origin-specific FAQs
- `individual` - For individual user FAQs

This field is optional and helps categorize FAQs for different user types or contexts.
