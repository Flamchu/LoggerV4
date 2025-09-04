# OCMS L1: Projekt - Logger 4

## Zadanie

Tvojou úlohou je previesť **Mini-Projekt Logger 1** do OCMS.

### Plugin

-   Všetko bude v jednom plugine `AppLogger.Logger`.

### Model

-   Budeš mať jeden model `Log`.
    -   V migrácii mu definuj stĺpce:
        -   `arrival` (timestamp)
        -   `name` (string)
        -   `late` (bool)

### Endpoints

-   **GET** - vráti všetky Logs
-   **GET** - vráti Logs s rovnakým menom
    -   použij route parameter `/logs/{name}`
-   **POST** - vytvorí nový Log
    -   použij form-data
    -   pri vytvorení zadefinuješ `name`, aktuálny čas `arrival` a vyhodnotíš `late`

### Validácia

-   Zabezpeč správnu validáciu cez model rules.

---

Zadanie môžeš pokojne rozšíriť, slúži hlavne na vyskúšanie si práce s OCMS. Všetko testuj cez Postmana.
