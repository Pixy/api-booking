# Installation

```sh
brew unlink php && brew link --overwrite --force php@8.0

composer create-project symfony/skeleton booking
cd booking
composer require api
composer require symfony/maker-bundle --dev
```

# Base de données

`vim docker-compose.yml`

```yml
version: "3.4"

services:
  database:
    image: postgres:13-alpine
    environment:
      - POSTGRES_DB=booking
      - POSTGRES_PASSWORD=api
      - POSTGRES_USER=api
    ports:
      - "5432:5432"
    volumes:
      - db_data:/var/lib/postgresql/data:rw

volumes:
  db_data:

```

Modifier le .env
`DATABASE_URL="postgresql://api:api@127.0.0.1:5432/booking?serverVersion=13&charset=utf8"`

```sh
bin/console doctrine:database:create
bin/console doctrine:schema:create
```

# Lancement du serveur

`php -S 127.0.0.1:8000 -t public`


# Création des entitées

`bin/console make:entity Lesson`

startsAt
datetime
no

endsAt
datetime
no

```sh
bin/console make:migration
bin/console doctrine:migrations:migrate
```

Ajouter

```php
#[ApiResource()]
```

`bin/console make:entity Learner`

firstname
lastname

```sh
bin/console make:migration
bin/console doctrine:migrations:migrate
```

`bin/console make:entity Booking`

status
learner -> relation -> Learner -> ManyToOne -> No -> Yes -> bookings -> Yes
lesson -> relation -> Lesson -> ManyToOne -> no -> yes -> bookings -> yes

```sh
bin/console make:migration
bin/console doctrine:migrations:migrate
```

```json
{
  "status": "string",
  "learnerId": "/api/learners/1",
  "lessonId": "/api/lessons/1"
}
```

# Ajout des groupes de normalisation

Dans `Booking.php` ajouter

```php
#[ApiResource(
    normalizationContext: ['groups' => ['booking']],
)]

// ...

    #[Groups(['booking'])]
    private $lesson;
```

Dans `Lesson.php`

```php
#[ApiResource(
    normalizationContext: ['groups' => ['lesson']]
)]

// ...

    #[Groups(['booking'])]
    private $startsAt;

    #[Groups(['booking'])]
    private $endsAt;

    #[Groups(['lesson'])]
    private $bookings;
```

# Ajout des groupes de dénormalisation

Dans `Booking.php`

```php
#[ApiResource(
    normalizationContext: ['groups' => ['booking']],
    denormalizationContext: ['groups' => ['booking:write']]
)]
class Booking {
    // ...
    #[Groups(['lesson', 'booking:write'])]
    private $status;

    #[Groups(['booking:write'])]
    private $learner;

    #[Groups(['booking', 'booking:write'])]
    private $lesson;
}
```