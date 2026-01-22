# Postman Collection for Ads CRUD

This collection contains comprehensive tests for Ads CRUD operations, including both public viewing endpoints and admin management endpoints.

## Files

1. **postman_ads_collection.json** - Postman collection with all Ads API endpoints
2. **postman_environment.json** - Environment variables (shared with main collection)

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_ads_collection.json`
4. The collection will be imported with all Ads CRUD endpoints

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

**Note:** Public endpoints (Get All Ads, Get Ad by ID, Search Ads) do not require authentication.

## Collection Structure

The collection is organized into two main folders:

### Public Endpoints (No Authentication Required)

#### 1. Get All Ads
- **Method**: GET
- **URL**: `/api/ads`
- **Query Parameters**:
  - `search` (optional): Search by title_en or title_ar
  - `type` (optional): Filter by type - `promotion` or `interface`
  - `is_active` (optional): Filter by active status - `true` or `false`
  - `sorted_by` (optional): Sort by `title`, `newest`, `oldest`, or `all` (default)
- **Response**: List of ads with pagination

#### 2. Get All Ads - With Filters
- **Method**: GET
- **URL**: `/api/ads?type=promotion&is_active=true&sorted_by=newest`
- **Description**: Example request with filters applied

#### 3. Get Ad by ID
- **Method**: GET
- **URL**: `/api/ads/{id}`
- **Note**: Requires `ad_id` variable (set automatically when creating an ad)

#### 4. Search Ads
- **Method**: GET
- **URL**: `/api/ads?search={term}&sorted_by={sort}`
- **Query Parameters**:
  - `search`: Search term (searches in title_en and title_ar)
  - `sorted_by`: Sort option

### Admin Endpoints (Authentication Required)

#### 1. Create Ad
- **Method**: POST
- **URL**: `/api/admin/ads`
- **Authentication**: Bearer token (admin_token)
- **Body**: Form-data with the following fields:
  - `title_en` (required): English title
  - `title_ar` (required): Arabic title
  - `description_en` (required): English description
  - `description_ar` (required): Arabic description
  - `is_active` (optional): Boolean - default: true
  - `btn_text_en` (optional): English button text
  - `btn_text_ar` (optional): Arabic button text
  - `btn_link` (optional): Button link URL
  - `btn_is_active` (optional): Boolean - default: false
  - `type` (optional): `promotion` or `interface` - default: promotion
  - `image` (required): Image file (jpeg, png, jpg, gif, webp, max 5MB)
- **Auto-saves**: `ad_id` to environment for use in other requests

#### 2. Update Ad
- **Method**: PUT
- **URL**: `/api/admin/ads/{id}`
- **Authentication**: Bearer token (admin_token)
- **Body**: Form-data (all fields optional):
  - `title_en` (optional): English title
  - `title_ar` (optional): Arabic title
  - `description_en` (optional): English description
  - `description_ar` (optional): Arabic description
  - `is_active` (optional): Boolean
  - `btn_text_en` (optional): English button text
  - `btn_text_ar` (optional): Arabic button text
  - `btn_link` (optional): Button link URL
  - `btn_is_active` (optional): Boolean
  - `type` (optional): `promotion` or `interface`
  - `image` (optional): Image file (only if updating image)
- **Note**: All fields are optional. You can update one or multiple fields. Image is optional - only include if you want to update the image.

#### 3. Update Ad - Text Only (No Image)
- **Method**: PUT
- **URL**: `/api/admin/ads/{id}`
- **Description**: Example request showing how to update text fields without updating the image

#### 4. Delete Ad
- **Method**: DELETE
- **URL**: `/api/admin/ads/{id}`
- **Authentication**: Bearer token (admin_token)
- **Note**: Requires `ad_id` variable (set automatically when creating an ad)

## Testing Flow

### Recommended Testing Order:

1. **First, login as admin (for admin endpoints):**
   - Use the main authentication collection
   - Login as admin to get `admin_token`

2. **Test Public Endpoints:**
   - Get All Ads
   - Get All Ads - With Filters
   - Search Ads
   - Get Ad by ID (requires ad_id - create an ad first or use an existing ID)

3. **Test Admin Endpoints:**
   - Create Ad (automatically saves `ad_id` to environment)
   - Get Ad by ID (uses saved `ad_id`)
   - Update Ad (uses saved `ad_id`)
   - Update Ad - Text Only (uses saved `ad_id`)
   - Delete Ad (uses saved `ad_id`)

## Request Examples

### Create Ad (Form-Data)
```
title_en: Summer Sale
title_ar: تخفيضات الصيف
description_en: Get amazing discounts on all products this summer!
description_ar: احصل على خصومات رائعة على جميع المنتجات هذا الصيف!
is_active: true
btn_text_en: Shop Now
btn_text_ar: تسوق الآن
btn_link: https://example.com/shop
btn_is_active: true
type: promotion
image: [Select image file]
```

### Update Ad (Form-Data - All Fields Optional)
```
title_en: Updated Title
is_active: false
[Other fields optional]
image: [Optional - only if updating image]
```

## Environment Variables

The following variables are used:

- `base_url` - API base URL (default: http://localhost:8000)
- `admin_token` - Admin authentication token (from main auth collection)
- `ad_id` - Ad ID (automatically saved when creating an ad)

## Notes

- **Public vs Admin Endpoints**: Public endpoints (GET) don't require authentication. Admin endpoints (POST, PUT, DELETE) require admin authentication.
- **Image Upload**: The `image` field is required when creating an ad, but optional when updating. When updating, only include the image field if you want to replace the existing image.
- **Form-Data**: Admin endpoints use `form-data` format (not JSON) because they support file uploads.
- **Ad ID**: The `ad_id` is automatically saved to the environment when you create an ad, and is used in subsequent requests (Get, Update, Delete).
- **Search**: Search works on both English and Arabic titles.
- **Filtering**: You can filter by `type` (promotion/interface) and `is_active` (true/false).
- **Sorting**: Available options are `title`, `newest`, `oldest`, or `all` (default).
- **Button Fields**: Button-related fields (`btn_text_en`, `btn_text_ar`, `btn_link`, `btn_is_active`) are optional and used for call-to-action buttons in ads.

## Response Examples

### Get All Ads Response
```json
{
    "message": "Ads retrieved successfully",
    "data": [
        {
            "id": 1,
            "title_en": "Summer Sale",
            "title_ar": "تخفيضات الصيف",
            "description_en": "Get amazing discounts...",
            "description_ar": "احصل على خصومات رائعة...",
            "is_active": true,
            "btn_text_en": "Shop Now",
            "btn_text_ar": "تسوق الآن",
            "btn_link": "https://example.com/shop",
            "btn_is_active": true,
            "type": "promotion",
            "image": "storage/ads/1/image.jpg",
            "created_at": "2026-01-21 12:00:00",
            "updated_at": "2026-01-21 12:00:00"
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

### Create Ad Response
```json
{
    "message": "Ad created successfully",
    "data": {
        "id": 1,
        "title_en": "Summer Sale",
        "title_ar": "تخفيضات الصيف",
        "description_en": "Get amazing discounts...",
        "description_ar": "احصل على خصومات رائعة...",
        "is_active": true,
        "btn_text_en": "Shop Now",
        "btn_text_ar": "تسوق الآن",
        "btn_link": "https://example.com/shop",
        "btn_is_active": true,
        "type": "promotion",
        "image": "storage/ads/1/image.jpg",
        "created_at": "2026-01-21 12:00:00",
        "updated_at": "2026-01-21 12:00:00"
    }
}
```

### Delete Ad Response
```json
{
    "message": "Ad deleted successfully"
}
```

## Image Requirements

- **Supported Formats**: jpeg, png, jpg, gif, webp
- **Maximum Size**: 5MB (5120 KB)
- **Required**: Yes for Create, Optional for Update
- **Collection**: Images are stored in the `image` media collection

## Error Responses

### 404 - Ad Not Found
```json
{
    "message": "Ad not found"
}
```

### 500 - Server Error
```json
{
    "message": "Failed to [operation] ad",
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
