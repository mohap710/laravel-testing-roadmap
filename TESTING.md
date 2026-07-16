## Unit vs Feature vs Integration tests

#### 1. Unit

- Unit test focus on individual code typically a method
- example: testing `isEven(int $number):bool` method return `true` if the number passed is even, otherwise `false`

#### 2. Feature

- Feature test focus on a complete user Journey to ensure the business logic works well as whole
- example: testing the `/api/register POST` with a valid payload and ensure it returns a `201 Created` response, sends a welcome email, and navigate the user to the profile page

#### 3. Integration

- Integration test focus on how Modules interacts with each other
- example: Verifying that a `UserRepository` successfully saves a record to a live test PostgreSQL database and reads it back without data type mismatch errors.

---

## Why TDD Red Green Refactor ?

`Test-Driven Development` is a programming practice where the test drive the software development.

- 🔴 Red stage: Writes a failing test case on the feature we want to implement.
- 🟢 Green stage: Implement the Feature so the test case can pass with minimal code.
- 🔵 Refactor stage: Improve on the existing solution, making sure that the test still passes.

A common criticism is that TDD can slow you down in some situations, especially when:

- requirements are unclear
- you’re exploring or prototyping
- working on UI or integrations

In these cases, writing tests first can feel like extra overhead without immediate benefit.

---
