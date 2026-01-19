# Postman Collection for Cities CRUD

This collection contains comprehensive tests for Cities CRUD operations.

## Files

1. **postman_cities_collection.json** - Postman collection with all Cities API endpoints
2. **postman_environment.json** - Environment variables (shared with main collection)

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_cities_collection.json`
4. The collection will be imported with all Cities CRUD endpoints

### 2. Import Environment (if not already imported)
1. In Postman, click on **Environments** in the left sidebar
2. Click **Import**
3. Select `postman_environment.json`
4. Select the imported environment from the dropdown (top right)

### 3. Configure Base URL
- The default base URL is set to `http://localhost:8000`
- If your Laravel app runs on a different URL, update the `base_url` variable in the environment

### 4. Get Admin Token
Before testing Cities endpoints, you need to:
1. Login as admin using the main authentication collection
2. The `admin_token` will be automatically saved to the environment
3. All Cities endpoints use `{{admin_token}}` for authentication

## Collection Structure

The collection includes the following endpoints:

### 1. Get All Cities
- **Method**: GET
- **URL**: `/api/admin/cities`
- **Query Parameters**:
  - `search` (optional): Search by name_en or name_ar
  - `sorted_by` (optional): Sort by `name`, `newest`, `oldest`, or `all`
- **Response**: List of cities with pagination

### 2. Get City by ID
- **Method**: GET
- **URL**: `/api/admin/cities/{id}`
- **Note**: Requires `city_id` variable (set automatically when creating a city)

### 3. Create City
- **Method**: POST
- **URL**: `/api/admin/cities`
- **Body**: 
  ```json
  {
      "name_en": "Riyadh",
      "name_ar": "الرياض"
  }
  ```
- **Auto-saves**: `city_id` to environment for use in other requests

### 4. Update City
- **Method**: PUT
- **URL**: `/api/admin/cities/{id}`
- **Body**: 
  ```json
  {
      "name_en": "Riyadh Updated",
      "name_ar": "الرياض المحدثة"
  }
  ```
- **Note**: Both `name_en` and `name_ar` are optional. You can update one or both fields.

### 5. Delete City
- **Method**: DELETE
- **URL**: `/api/admin/cities/{id}`
- **Note**: Cannot delete city if it has associated regions. Delete regions first.

### 6. Search Cities
- **Method**: GET
- **URL**: `/api/admin/cities?search={term}&sorted_by={sort}`
- **Query Parameters**:
  - `search`: Search term (searches in name_en and name_ar)
  - `sorted_by`: Sort option

## Testing Flow

### Recommended Testing Order:

1. **First, login as admin:**
   - Use the main authentication collection
   - Login as admin to get `admin_token`

2. **Create a city:**
   - Use "Create City" request
   - This automatically saves `city_id` to environment

3. **Test other operations:**
   - Get All Cities
   - Get City by ID (uses saved `city_id`)
   - Update City (uses saved `city_id`)
   - Search Cities
   - Delete City (uses saved `city_id`)

## Request Examples

### Create City
```json
{
    "name_en": "Riyadh",
    "name_ar": "الرياض"
}
```

### Update City
```json
{
    "name_en": "Riyadh Updated",
    "name_ar": "الرياض المحدثة"
}
```

**Note:** Both `name_en` and `name_ar` are optional in update requests. You can update one or both fields.

## Environment Variables

The following variables are used:

- `base_url` - API base URL (default: http://localhost:8000)
- `admin_token` - Admin authentication token (from main auth collection)
- `city_id` - City ID (automatically saved when creating a city)

## Notes

- **Admin Authentication Required**: All Cities endpoints require admin authentication
- **City Deletion**: A city cannot be deleted if it has associated regions. Delete regions first, then delete the city
- **City ID**: The `city_id` is automatically saved to the environment when you create a city, and is used in subsequent requests (Get, Update, Delete)
- **Search**: Search works on both English and Arabic names
- **Sorting**: Available options are `name`, `newest`, `oldest`, or `all` (default)

## Response Examples

### Get All Cities Response
```json
{
    "message": "Cities retrieved successfully",
    "data": [
        {
            "id": 1,
            "name_en": "Riyadh",
            "name_ar": "الرياض",
            "created_at": "2026-01-19 12:00:00",
            "updated_at": "2026-01-19 12:00:00"
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

### Create City Response
```json
{
    "message": "City created successfully",
    "data": {
        "id": 1,
        "name_en": "Riyadh",
        "name_ar": "الرياض",
        "created_at": "2026-01-19 12:00:00",
        "updated_at": "2026-01-19 12:00:00"
    }
}
```
