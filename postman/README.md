# Postman – Pages & Contents API

## Import

1. **Collection:** In Postman → Import → Upload `Pages_and_Contents.postman_collection.json`
2. **Environment (optional):** Import → Upload `Pages_and_Contents.postman_environment.json` and select it in the environment dropdown.

## Variables

- **base_url** – API base (default: `http://localhost:8000/api`)
- **token** – Bearer token for admin routes (set after **Auth > Login** or manually)
- **page_id** – Used in Get/Update/Delete Page and in content filters (default: `1`)
- **content_id** – Used in Get/Update/Delete Content (default: `1`)

## Flow

1. Run **Auth > Login** with your admin email/password. The collection script stores the token in `token`.
2. Use **Pages** or **Contents** requests. Admin requests use `Authorization: Bearer {{token}}`.

## Contents and images

- **Create/Update with JSON:** Use for `card` or `list` (no file).
- **Create/Update img_text with image:** Use the **form-data** requests and choose a file for the `image` key (jpeg, png, jpg, gif, webp; max 5MB).
