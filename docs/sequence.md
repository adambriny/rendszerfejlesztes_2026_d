```mermaid
sequenceDiagram
    autonumber
    actor Guest as Látogató / Diák
    participant UI as Frontend UI
    participant API as Backend API
    participant DB as phpMyAdmin (MySQL DB)
    actor Teacher as Tanár

    %% 1. Keresés és Szűrés (F05)
    Guest->>UI: Tantárgy, ár-tartomány és időpont megadása
    UI->>API: GET /api/teachers/search?subject=...&min_price=...&max_price=...
    API->>DB: SELECT * FROM TeacherProfiles JOIN TeacherSubjects...
    DB-->>API: Elérhető tanárok és szabad idősávok listája
    API-->>UI: JSON válasz adatokkal
    UI-->>Guest: Szűrt tanárlista és elérhetőségek megjelenítése

    %% 2. Órafoglalás (F06, F07)
    Guest->>UI: Bejelentkezés (/login/student) & Szabad idősáv kiválasztása
    UI->>API: POST /api/bookings (student_id, availability_id)
    API->>DB: INSERT INTO Bookings (student_id, availability_id, status='PENDING')
    DB-->>API: Foglalás rögzítve (id & PENDING státusz)
    API-->>UI: HTTP 201 Created (Foglalás függőben)
    UI-->>Guest: Értesítés: "Foglalás elküldve, tanár jóváhagyására vár"

    %% 3. Tanári Jóváhagyás és Állapotkezelés (F07)
    Teacher->>UI: Bejelentkezés (/login/teacher) & Naptár megtekintése
    UI->>API: GET /api/teacher/bookings?status=PENDING
    API->>DB: SELECT * FROM Bookings WHERE status = 'PENDING'
    DB-->>API: Függőben lévő foglalások listája
    API-->>UI: Foglalási kérelmek adatai
    UI-->>Teacher: Függő foglalások listázása

    Teacher->>UI: Foglalás elfogadása ("Elfogadás" gomb)
    UI->>API: PATCH /api/bookings/{id}/confirm
    API->>DB: UPDATE Bookings SET status = 'CONFIRMED' WHERE id = {id}
    DB-->>API: Módosítás sikeres
    API-->>UI: HTTP 200 OK
    UI-->>Teacher: Visszajelzés: Foglalás sikeresen megerősítve