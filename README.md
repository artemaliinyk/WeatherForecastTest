# Weather Forecast Web App Code Test

### .env

OPENWEATHER_API_KEY=e4b8b08c185638b825af37facfe1fabb

OPENWEATHER_URL=http://api.openweathermap.org/data/2.5/forecast

## Overview
In this test, you will create a simple Weather Forecast web app.

### Requirements
- Show forecast dynamically (using an API).
- Create and use a database to manage forecasts.
- Implement front-end interaction with the database.

### Tasks
- Show forecasts dynamically; for any city name (e.g. "Tel Aviv"), and show the forecast period, date/time, min temp, max temp, average temp, wind speed.
- Create a "Save Forecast" button to save the forecast in the database. The button will save ONLY the FIRST forecast item, matching the most-recent time in the API's response. *Note: If the forecast for a city already exists in the database, update the forecast entry, do not keep a city duplication.*
- Create a "Load from db" button to load a forecast from the database by the city's name, the same one you saved in the last task.

### API
Use the OpenWeatherMap API for fetching forecasts.

### Server
- Server Side – PHP + Laravel
- Database – MySQL. *Note: Use your own migrations.*

### Setup
- Create a new Laravel project, called weather.
- Create a new database (using PhpMyAdmin/DataGrip/the terminal/etc.).
- Create a database migration, a model and a controller in Laravel.
- The migrations must handle:
  - A UNIX timestamp (given by the API).
  - city name.
  - minimum temperature.
  - maximum temperature.
  - Wind speed.
  - Laravel timestamps (created_at, updated_at).

### Frontend Code Structure
You can use any structure you see fit when it comes to the frontend, either stored in the same project as Laravel, using Laravel views or in separate projects.

*Examples for the UI are included in the "/examples" folder.*

## Required to use:
- OpenWeatherMap API - `http://api.openweathermap.org/data/2.5/forecast?q={CITY NAME}&units=metric&appid={YOUR API KEY}`
- API Documentation - `http://openweathermap.org/forecast5`

## Client Side
- Use any framework or library you wish (or vanilla JS).

---

*Note: This README.md is a template for the Weather Forecast Web App Code Test.*
