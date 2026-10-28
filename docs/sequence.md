graph TD
    classDef default fill:#f9f9f9,stroke:#333,stroke-width:1px;

    subgraph Felhasználók
        Guest["Látogató"]
        Student["Diák"]
        Teacher["Tanár"]
        Admin["Adminisztrátor"]
    end

    subgraph Felületek
        PublicSite["Nyilvános Kezdőlap"]
        StudentPortal["Diák Irányítópult"]
        TeacherPortal["Tanári Felület"]
        AdminPortal["Admin Felület"]
    end

    subgraph Rendszerfunkciók
        SearchEngine["Kereső & Szűrő Modul"]
        BookingEngine["Órafoglalás"]
        ScheduleManager["Naptárkezelő"]
        ReviewSystem["Értékelési Rendszer"]
    end

    subgraph Adatbázis
        DB_Users[("Users")]
        DB_Teachers[("TeacherProfiles")]
        DB_Subjects[("Subjects")]
        DB_Availabilities[("Availabilities")]
        DB_Bookings[("Bookings")]
    end

    Guest -->|Böngészés| PublicSite
    Student -->|Bejelentkezés| StudentPortal
    Teacher -->|Bejelentkezés| TeacherPortal
    Admin -->|Bejelentkezés| AdminPortal

    PublicSite --> SearchEngine
    StudentPortal --> SearchEngine
    SearchEngine --> BookingEngine
    TeacherPortal --> ScheduleManager
    BookingEngine --> ReviewSystem

    StudentPortal --> DB_Bookings
    TeacherPortal --> DB_Teachers
    TeacherPortal --> DB_Availabilities
    SearchEngine --> DB_Subjects
    AdminPortal --> DB_Users
