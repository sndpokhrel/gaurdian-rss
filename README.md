# Guardian RSS Feed Generator
The challenge requires developing a server-side application in PHP exposing RSS feeds corresponding to the categories of The Guardian, a leading UK newspaper. User can ask for URLs in the format `/[section-name]`, corresponding sections like `/technology`, `/world`, `/environment`, and revice RSS feeds with latest articles.

## Requirement Done
- **Framework**:Laravel.
- **RSS Feed Generation**: Convert json api to rss feeds and rss feed womplies with W3C Standard.
- **Validation**: Middleware validation for section names only accepting value with lowercase letters and hypens.
- **Caching**: Cache is used to store api response for 10min.
- **Error Handling**: Invalid section name or empty api are handeled.
- **Unit and Integration Test**: Unit and Integration tests are added and assertion is used for library.
- **Docker**: Wrap all in docker file.
- **Lint**: Using lint with PSR-12 coding standards using phpcs.

---

## Pre-installations

- PHP 8.2 or higher
- Composer
- Docker and Docker Compose
- Guardian Api key from https://open-platform.theguardian.com/access and replace API_KEY in .env with authorized API key.

---

## Steps to run app

1. **Clone repo:**

   ```bash
   git clone <repository-url>
   cd guardian-rss

2. **Set up environment variable**
    Provide API Key in GUARDIAN_API_KEY in the .env file:

   ```bash
   GUARDIAN_API_KEY=e8e99174-a76b-4eb4-801f-c6998511fe70 //This API didnot work for me I used my own API
3. **Build and start container**
    ```bash
    docker compose up --build -d
4. **Browser App**
   `http://localhost:8000/[section-name]`, e.g. `/technology`, `/lifeandstyle`
