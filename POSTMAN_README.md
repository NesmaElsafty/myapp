# Postman Collection for Authentication Cycle

This collection contains comprehensive tests for the authentication cycle for all user types.

## Files

1. **postman_collection.json** - Main Postman collection with all API endpoints
2. **postman_environment.json** - Environment variables for the collection

## Setup Instructions

### 1. Import Collection
1. Open Postman
2. Click **Import** button
3. Select `postman_collection.json`
4. The collection will be imported with all folders organized by user type

### 2. Import Environment
1. In Postman, click on **Environments** in the left sidebar
2. Click **Import**
3. Select `postman_environment.json`
4. Select the imported environment from the dropdown (top right)

### 3. Configure Base URL
- The default base URL is set to `http://localhost:8000`
- If your Laravel app runs on a different URL, update the `base_url` variable in the environment

## Collection Structure

The collection is organized into 5 folders, one for each user type:

### 1. User Type
- Register User
- Login User
- Get Authenticated User
- Logout User

### 2. Admin Type
- Register Admin
- Login Admin
- Get Authenticated Admin
- Logout Admin

### 3. Individual Type
- Register Individual (requires `national_id`)
- Login Individual
- Get Authenticated Individual
- Logout Individual

### 4. Origin Type
- Register Origin (requires `commercial_number`)
- Login Origin
- Get Authenticated Origin
- Logout Origin

### 5. Agent Type
- Register Agent (requires `origin_id` - must register Origin first)
- Login Agent
- Get Authenticated Agent
- Logout Agent

## Testing Flow

### Recommended Testing Order:

1. **First, register an Origin user:**
   - Go to `Origin Type` → `Register Origin`
   - This will automatically save the `origin_id` and `origin_token` to environment variables

2. **Then register an Agent:**
   - Go to `Agent Type` → `Register Agent`
   - The `origin_id` from step 1 will be automatically used
   - This will save the `agent_token` and `agent_id`

3. **Test other user types:**
   - Register and test User, Admin, and Individual types in any order

### Automatic Token Management

Each register/login request automatically saves:
- `{type}_token` - Authentication token for that user type
- `{type}_id` - User ID for that user type

These tokens are automatically used in subsequent requests (Get Authenticated User, Logout) via the `Authorization: Bearer {{type}_token}` header.

## Request Examples

### Register User (User Type)
```json
{
    "f_name": "John",
    "l_name": "Doe",
    "email": "user@example.com",
    "phone": "1234567890",
    "password": "password123",
    "password_confirmation": "password123",
    "type": "user"
}
```

### Register Individual (Individual Type)
```json
{
    "f_name": "Jane",
    "l_name": "Smith",
    "email": "individual@example.com",
    "phone": "1234567892",
    "password": "password123",
    "password_confirmation": "password123",
    "type": "individual",
    "national_id": "12345678901234"
}
```

### Register Origin (Origin Type)
```json
{
    "f_name": "Origin",
    "l_name": "Company",
    "email": "origin@example.com",
    "phone": "1234567893",
    "password": "password123",
    "password_confirmation": "password123",
    "type": "origin",
    "commercial_number": "CR123456789"
}
```

### Register Agent (Agent Type)
```json
{
    "f_name": "Agent",
    "l_name": "One",
    "email": "agent@example.com",
    "phone": "1234567894",
    "password": "password123",
    "password_confirmation": "password123",
    "type": "agent",
    "origin_id": "{{origin_id}}"
}
```

### Login (with type - optional but recommended)
```json
{
    "email": "user@example.com",
    "password": "password123",
    "type": "user"
}
```

**Note:** The `type` field in login is optional. However, if the same email exists for multiple user types, you must include the `type` field to specify which account to login to.

## Environment Variables

The following variables are automatically managed:

- `base_url` - API base URL (default: http://localhost:8000)
- `user_token` - Token for user type
- `user_id` - ID for user type
- `admin_token` - Token for admin type
- `admin_id` - ID for admin type
- `individual_token` - Token for individual type
- `individual_id` - ID for individual type
- `origin_token` - Token for origin type
- `origin_id` - ID for origin type (used by agents)
- `agent_token` - Token for agent type
- `agent_id` - ID for agent type

## Notes

- Make sure your Laravel application is running before testing
- For Agent registration, you must register an Origin user first
- All passwords in the examples are `password123` - change them as needed
- **Email and phone uniqueness**: Email and phone must be unique **per user type**. This means:
  - The same email can be used for different user types (e.g., `test@example.com` as a user AND as an admin)
  - But the same email cannot be used twice for the same user type
  - Same applies to phone numbers
- **Login with type**: When logging in, you can optionally include the `type` field. If an email exists in multiple user types, the `type` field is required to identify which account to login to
