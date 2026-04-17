# 🏢 Organization System Database Design

## 📌 Overview

This structure is designed for a scalable organization system with:

- Multi-organizations
- Membership system
- Departments & roles
- Hierarchical structure

---

## 🧩 organizations

organizations

id (PK)
name
slug (unique)
description (nullable)
owner_id (FK → users.id)
created_at
updated_at
deleted_at

---

## 🧩 memberships

memberships

id (PK)
user_id (FK → users.id)
organization_id (FK → organizations.id)

status (active | invited | suspended)
joined_at (nullable)

created_at
updated_at

UNIQUE (user_id, organization_id)

---

## 🧩 departments

departments

id (PK)
organization_id (FK → organizations.id)

name

created_at
updated_at

UNIQUE (organization_id, name)

---

## 🧩 positions

positions

id (PK)
department_id (FK → departments.id)

name

created_at
updated_at

---

## 🧩 seniorities

seniorities

id (PK)

name (junior | mid | senior | lead)
level (int)

created_at
updated_at

---

## 🧩 leadership_roles

leadership_roles

id (PK)

name (team_lead | head | cto | ceo)
level (int)

created_at
updated_at

---

## 🧩 placements 🔥

placements

id (PK)

membership_id (FK → memberships.id)
department_id (FK → departments.id)
position_id (FK → positions.id)
seniority_id (FK → seniorities.id)

leadership_role_id (nullable FK → leadership_roles.id)

reports_to (nullable FK → placements.id)

created_at
updated_at

---

## 🔗 Relationships Overview

User
↓
Membership
↓
Organization

Membership
↓
Placement
↓
Department → Position

Placement
↓
reports_to → Placement (hierarchy)

---

## 💡 Key Concepts

- **Membership** = User belongs to an organization
- **Placement** = User role inside organization
- **reports_to** = Hierarchy (manager system)

---

## ⚠️ Important Constraints

- `organizations.slug` → UNIQUE
- `memberships (user_id, organization_id)` → UNIQUE
- `departments (organization_id, name)` → UNIQUE
- `placements.reports_to` → self-reference (hierarchy)

---

## 🚀 Next Step

- Implement **Slug Uniqueness Logic**
- Then build **Membership Flow**
