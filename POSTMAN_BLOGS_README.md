# Postman Collection for Blogs CRUD

This collection contains comprehensive tests for Blogs CRUD operations, including both public viewing endpoints and admin management endpoints.

## Files

1. **postman_blogs_collection.json** - Postman collection with all Blogs API endpoints
2. **postman_environment.json** - Environment variables (shared with main collection)

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_blogs_collection.json`
4. The collection will be imported with all Blogs CRUD endpoints

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

**Note:** Public endpoints (Get All Blogs, Get Blog by ID, Search Blogs) do not require authentication.

## Collection Structure

The collection is organized into two main folders:

### Public Endpoints (No Authentication Required)

#### 1. Get All Blogs
- **Method**: GET
- **URL**: `/api/blogs`
- **Query Parameters**:
  - `search` (optional): Search by title_en or title_ar
  - `is_active` (optional): Filter by active status - `true` or `false`
  - `sorted_by` (optional): Sort by `title`, `newest`, `oldest`, or `all` (default)
- **Response**: List of blogs with pagination

#### 2. Get All Blogs - With Filters
- **Method**: GET
- **URL**: `/api/blogs?is_active=true&sorted_by=newest`
- **Description**: Example request with filters applied

#### 3. Get Blog by ID
- **Method**: GET
- **URL**: `/api/blogs/{id}`
- **Note**: Requires `blog_id` variable (set automatically when creating a blog)

#### 4. Search Blogs
- **Method**: GET
- **URL**: `/api/blogs?search={term}&sorted_by={sort}`
- **Query Parameters**:
  - `search`: Search term (searches in title_en and title_ar)
  - `sorted_by`: Sort option

### Admin Endpoints (Authentication Required)

#### 1. Create Blog
- **Method**: POST
- **URL**: `/api/admin/blogs`
- **Authentication**: Bearer token (admin_token)
- **Body**: Form-data with the following fields:
  - `title_en` (required): English title
  - `title_ar` (required): Arabic title
  - `description_en` (required): English description
  - `description_ar` (required): Arabic description
  - `is_active` (optional): Boolean - default: true
  - `image` (required): Image file (jpeg, png, jpg, gif, webp, max 5MB)
- **Auto-saves**: `blog_id` to environment for use in other requests

#### 2. Update Blog
- **Method**: PUT
- **URL**: `/api/admin/blogs/{id}`
- **Authentication**: Bearer token (admin_token)
- **Body**: Form-data (all fields optional):
  - `title_en` (optional): English title
  - `title_ar` (optional): Arabic title
  - `description_en` (optional): English description
  - `description_ar` (optional): Arabic description
  - `is_active` (optional): Boolean
  - `image` (optional): Image file (only if updating image)
- **Note**: All fields are optional. You can update one or multiple fields. Image is optional - only include if you want to update the image.

#### 3. Update Blog - Text Only (No Image)
- **Method**: PUT
- **URL**: `/api/admin/blogs/{id}`
- **Description**: Example request showing how to update text fields without updating the image

#### 4. Delete Blog
- **Method**: DELETE
- **URL**: `/api/admin/blogs/{id}`
- **Authentication**: Bearer token (admin_token)
- **Note**: Requires `blog_id` variable (set automatically when creating a blog)

## Testing Flow

### Recommended Testing Order:

1. **First, login as admin (for admin endpoints):**
   - Use the main authentication collection
   - Login as admin to get `admin_token`

2. **Test Public Endpoints:**
   - Get All Blogs
   - Get All Blogs - With Filters
   - Search Blogs
   - Get Blog by ID (requires blog_id - create a blog first or use an existing ID)

3. **Test Admin Endpoints:**
   - Create Blog (automatically saves `blog_id` to environment)
   - Get Blog by ID (uses saved `blog_id`)
   - Update Blog (uses saved `blog_id`)
   - Update Blog - Text Only (uses saved `blog_id`)
   - Delete Blog (uses saved `blog_id`)

## Request Examples

### Create Blog (Form-Data)
```
title_en: Introduction to Laravel
title_ar: مقدمة إلى Laravel
description_en: Laravel is a powerful PHP framework...
description_ar: Laravel هو إطار عمل PHP قوي...
is_active: true
image: [Select image file]
```

### Update Blog (Form-Data - All Fields Optional)
```
title_en: Updated Blog Title
is_active: false
[Other fields optional]
image: [Optional - only if updating image]
```

## Environment Variables

The following variables are used:

- `base_url` - API base URL (default: http://localhost:8000)
- `admin_token` - Admin authentication token (from main auth collection)
- `blog_id` - Blog ID (automatically saved when creating a blog)

## Notes

- **Public vs Admin Endpoints**: Public endpoints (GET) don't require authentication. Admin endpoints (POST, PUT, DELETE) require admin authentication.
- **Image Upload**: The `image` field is required when creating a blog, but optional when updating. When updating, only include the image field if you want to replace the existing image.
- **Form-Data**: Admin endpoints use `form-data` format (not JSON) because they support file uploads.
- **Blog ID**: The `blog_id` is automatically saved to the environment when you create a blog, and is used in subsequent requests (Get, Update, Delete).
- **Search**: Search works on both English and Arabic titles.
- **Filtering**: You can filter by `is_active` (true/false).
- **Sorting**: Available options are `title`, `newest`, `oldest`, or `all` (default).

## Response Examples

### Get All Blogs Response
```json
{
    "message": "Blogs retrieved successfully",
    "data": [
        {
            "id": 1,
            "title_en": "Introduction to Laravel",
            "title_ar": "مقدمة إلى Laravel",
            "description_en": "Laravel is a powerful PHP framework...",
            "description_ar": "Laravel هو إطار عمل PHP قوي...",
            "is_active": true,
            "image": "storage/blogs/1/image.jpg",
            "created_at": "2026-01-22 12:00:00",
            "updated_at": "2026-01-22 12:00:00"
        }
    ],
    "pagination": {
        "current_page": 1,
        "per_page": 10,
        "total": 1,
        "last_page": 1
    }
}
```

### Create Blog Response
```json
{
    "message": "Blog created successfully",
    "data": {
        "id": 1,
        "title_en": "Introduction to Laravel",
        "title_ar": "مقدمة إلى Laravel",
        "description_en": "Laravel is a powerful PHP framework...",
        "description_ar": "Laravel هو إطار عمل PHP قوي...",
        "is_active": true,
        "image": "storage/blogs/1/image.jpg",
        "created_at": "2026-01-22 12:00:00",
        "updated_at": "2026-01-22 12:00:00"
    }
}
```

### Delete Blog Response
```json
{
    "message": "Blog deleted successfully"
}
```

## Image Requirements

- **Supported Formats**: jpeg, png, jpg, gif, webp
- **Maximum Size**: 5MB (5120 KB)
- **Required**: Yes for Create, Optional for Update
- **Collection**: Images are stored in the `image` media collection

## Error Responses

### 404 - Blog Not Found
```json
{
    "message": "Blog not found"
}
```

### 500 - Server Error
```json
{
    "message": "Failed to [operation] blog",
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
        "title_en": ["The title en field is required."],
        "image": ["The image field is required."]
    }
}
```
