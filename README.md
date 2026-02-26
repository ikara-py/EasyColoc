# EasyColoc

EasyColoc is a Laravel-based roommate management web application designed to track shared household expenses and automatically calculate who owes whom. The system eliminates manual calculations and enforces structured financial accountability within shared living environments.

---

## 1. Core Concept & Architecture

EasyColoc is built using a strict monolithic MVC architecture with a clear separation of concerns between models, controllers, and views.

### Technology Stack

- Backend: Laravel (Monolithic MVC)
- Database: MySQL or PostgreSQL
- ORM: Eloquent
- Authentication: Laravel Breeze or Jetstream
- Frontend: Blade Templates and Tailwind CSS
- Version Control: Git and GitHub

The application heavily relies on `belongsToMany` relationships and pivot tables, particularly for managing group-level roles inside colocations.

---

## 2. Two-Tier Role System

A user may only belong to one active colocation at a time. Permissions are determined by a two-tier system.

---

### Tier A: Platform Roles (Global)

These roles define permissions across the entire platform.

#### Admin
- Automatically assigned to the first registered user.
- Access to a global statistics dashboard (users, colocations, expenses).
- Ability to ban or unban users.
- Banned users are immediately logged out and blocked.

#### User
- Default role for all other accounts.
- Can create a new colocation.
- Can join an existing colocation via invitation.

Platform roles are stored directly on the `users` table.

---

### Tier B: Group Roles (Inside a Colocation)

These roles define permissions inside a specific colocation.

Group roles are stored in the `colocation_user` pivot table.

#### Owner
- Automatically assigned to the user who creates a colocation.
- Can invite new users via email or secure token.
- Can remove members from the group.
- Can manage expense categories.
- Can cancel or delete the colocation.

#### Member
- Joins a colocation via invitation.
- Can view members, roles, and reputation scores.
- Can add expenses.
- Can view balances and debts.
- Can mark debts as paid.
- Can voluntarily leave the colocation.

The pivot table stores:
- `user_id`
- `colocation_id`
- `role` (owner or member)
- timestamps

---

## 3. Core Features & Business Logic

### A. Expense Tracking & Balance Engine

- Any active group member can add an expense.
- Required fields: title, amount, date, category, payer.
- The system instantly recalculates balances.
- A synthetic dashboard displays "who owes what to whom".
- Expense history can be filtered by month.

#### Settling Debts
Users register payments using a "Mark as Paid" action.  
Balances are recalculated automatically.

---

### B. Reputation System

Each user has a financial reputation score based on exit behavior.

- +1 Point: Leaving a colocation with no outstanding debt.
- -1 Point: Leaving while still owing money.

#### Owner Exception Rule
If an Owner forcibly removes a Member who still owes money:
- The debt is transferred to the Owner.
- The balance engine recalculates immediately.

---

### C. Blocking Logic

- A user already inside an active colocation cannot:
  - Create another colocation.
  - Accept an invitation to another colocation.

This rule is strictly enforced at the controller and middleware levels.

---

## 4. Security Implementation

- CSRF protection using `@csrf`
- XSS protection using Blade escaping `{{ }}`
- Server-side validation via Form Requests
- Client-side HTML5 validation
- Role-based middleware protection
- Protection against SQL injection through Eloquent ORM

---

## 5. Database Design

Main Entities:
- Users
- Colocations
- Expenses
- Categories
- Colocation_User (pivot table with role)

Relationships:
- Users ↔ Colocations (Many-to-Many with role on pivot)
- Colocation → Expenses (One-to-Many)
- Expense → Category (Belongs-To)

The pivot table plays a critical role in enforcing group-level permissions.

---

## 6. Setup Instructions

1. Clone the repository.

2. Install dependencies:
```
   composer install  
   npm install  
```

3. Configure the `.env` file.

4. Run migrations and seeders:
```
   php artisan migrate --seed

```  

5. Start the development server:

```
   php artisan serve  
```

---

## Author
**Ali Kara**