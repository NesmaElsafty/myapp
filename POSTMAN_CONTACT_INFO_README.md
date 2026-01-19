# Postman Collection for Contact Info CRUD

This collection contains comprehensive tests for Contact Info and Social Media management operations.

## Files

1. **postman_contact_info_collection.json** - Postman collection with all Contact Info API endpoints
2. **postman_environment.json** - Environment variables (shared with main collection)

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_contact_info_collection.json`
4. The collection will be imported with all Contact Info endpoints

### 2. Import Environment (if not already imported)
1. In Postman, click on **Environments** in the left sidebar
2. Click **Import**
3. Select `postman_environment.json`
4. Select the imported environment from the dropdown (top right)

### 3. Configure Base URL
- The default base URL is set to `http://localhost:8000`
- If your Laravel app runs on a different URL, update the `base_url` variable in the environment

### 4. Get Admin Token
Before testing the store endpoint, you need to:
1. Login as admin using the main authentication collection
2. The `admin_token` will be automatically saved to the environment
3. The store endpoint uses `{{admin_token}}` for authentication

## Collection Structure

The collection includes the following endpoints:

### 1. Get Contact Info
- **Method**: GET
- **URL**: `/api/contact-info`
- **Authentication**: None (Public endpoint)
- **Response**: Contact info and social media array
- **Description**: Retrieves contact information and all social media links

### 2. Update or Create Contact Info (Single Social Media)
- **Method**: POST
- **URL**: `/api/admin/contact-info`
- **Authentication**: Required (Admin token)
- **Body**: Contact info with single social media object
- **Description**: Updates or creates contact info with one social media entry

### 3. Update or Create Contact Info (Multiple Social Media)
- **Method**: POST
- **URL**: `/api/admin/contact-info`
- **Authentication**: Required (Admin token)
- **Body**: Contact info with array of social media objects
- **Description**: Updates or creates contact info with multiple social media entries

### 4. Update or Create Contact Info (Without Social Media)
- **Method**: POST
- **URL**: `/api/admin/contact-info`
- **Authentication**: Required (Admin token)
- **Body**: Contact info only (no social media)
- **Description**: Updates or creates contact info without social media

### 5. Update Contact Info - Validation Error
- **Method**: POST
- **URL**: `/api/admin/contact-info`
- **Authentication**: Required (Admin token)
- **Body**: Invalid data to test validation
- **Description**: Tests validation error handling

## Request Examples

### Get Contact Info
```
GET /api/contact-info
```

**Response:**
```json
{
    "message": "Contact info retrieved successfully",
    "data": {
        "contact_info": {
            "id": 1,
            "phone": "+966501234567",
            "email": "info@example.com",
            "copyright": "© 2026 All Rights Reserved"
        },
        "social_media": [
            {
                "id": 1,
                "platform": "Facebook",
                "url": "https://www.facebook.com/example"
            },
            {
                "id": 2,
                "platform": "Twitter",
                "url": "https://www.twitter.com/example"
            }
        ]
    }
}
```

### Update or Create Contact Info (With Social Media)
```json
{
    "phone": "+966501234567",
    "email": "info@example.com",
    "copyright": "© 2026 All Rights Reserved",
    "social_media": {
        "platform": "Facebook",
        "url": "https://www.facebook.com/example"
    }
}
```

### Update or Create Contact Info (Multiple Social Media)
```json
{
    "phone": "+966501234567",
    "email": "info@example.com",
    "copyright": "© 2026 All Rights Reserved",
    "social_media": [
        {
            "platform": "Facebook",
            "url": "https://www.facebook.com/example"
        },
        {
            "platform": "Twitter",
            "url": "https://www.twitter.com/example"
        },
        {
            "platform": "Instagram",
            "url": "https://www.instagram.com/example"
        }
    ]
}
```

### Update or Create Contact Info (Without Social Media)
```json
{
    "phone": "+966501234567",
    "email": "info@example.com",
    "copyright": "© 2026 All Rights Reserved"
}
```

## Validation Rules

### Contact Info Fields:
- `phone` - Required, string, max 255 characters
- `email` - Required, string, max 255 characters
- `copyright` - Required, string, max 255 characters

### Social Media Fields (if provided):
- `social_media` - Optional, array
- `social_media.*.platform` - Required if social_media is provided, string, max 255 characters
- `social_media.*.url` - Required if social_media is provided, string, max 255 characters

## Testing Flow

### Recommended Testing Order:

1. **First, login as admin:**
   - Use the main authentication collection
   - Login as admin to get `admin_token`

2. **Get contact info:**
   - Use "Get Contact Info" request (no authentication needed)
   - This will show current contact info and social media

3. **Update contact info:**
   - Use "Update or Create Contact Info" requests
   - Try different variations (with/without social media)

4. **Test validation:**
   - Use "Update Contact Info - Validation Error" request
   - Verify that validation errors are returned correctly

## Environment Variables

The following variables are used:

- `base_url` - API base URL (default: http://localhost:8000)
- `admin_token` - Admin authentication token (from main auth collection)

## Notes

- **Public Endpoint**: The GET endpoint is public and does not require authentication
- **Admin Authentication**: The POST endpoint requires admin authentication
- **Update or Create**: The store method uses `updateOrCreate` with `id => 1`, so it will always update the first record or create it if it doesn't exist
- **Social Media Handling**: The current implementation may only handle one social media entry at a time. Check the controller logic for multiple entries support
- **Single Record**: Contact info is designed to have only one record (id = 1)

## Response Examples

### Success Response
```json
{
    "message": "Contact info updated successfully",
    "data": {
        "id": 1,
        "phone": "+966501234567",
        "email": "info@example.com",
        "copyright": "© 2026 All Rights Reserved",
        "created_at": "2026-01-19 12:00:00",
        "updated_at": "2026-01-19 12:00:00"
    }
}
```

### Validation Error Response
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "phone": [
            "The phone field is required."
        ],
        "email": [
            "The email must be a valid email address."
        ]
    }
}
```
