<p align="center">
  <img src="logo.png" width="200">
</p>


Реалізація з використанням тонких контролерів. Вхідні дані валідуються Request-формами. Бізнес логіка реалізована у сервісному шарі.

Покращення: додати тести ендпоінтів, тули для статичного аналізу, документацію API.

## 🚀 Як запустити

1. Склонувати `git clone https://github.com/rizort/leads.git`

2. Сбілдити контейнери, вставновити composer-залежності `make init`

3. Підняти контейнери: `make up`

## Перевірка

### Створення ліда
```bash
curl -k -X POST https://localhost/api/leads \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "phone": "+380501234567",
    "manager_id": 1
  }'
```

### Додання дзвінка ліду
```bash
curl -k -X POST https://localhost/api/leads/1/calls \
  -H "Content-Type: application/json" \
  -d '{
    "duration": 120,
    "result": "success",
    "manager_id": 1
  }'
```

### Перегляд лідів менеджера
```bash
curl -k https://localhost/api/managers/1/leads
```
