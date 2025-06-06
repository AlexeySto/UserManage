# UserManage

UserManage — это веб-приложение для управления списком пользователей.

## О проекте

Целью проекта UserManage было создание веб-приложения для эффективного управления списком пользователей. Проект разработан на чистом PHP с использованием шаблонизатора Twig для создания динамичного и отзывчивого пользовательского интерфейса. Для хранения данных используется система управления базами данных MySQL.

## Инструкция по развертыванию

1. **Клонирование репозитория:**
   ```bash
    git clone https://github.com/AlexeySto/UserManage.git
    cd UserManage

2. **Установка зависимостей:**
   ```bash
     cd ./code
     composer install
     cd ..
   
3. **Сборка и запуск контейнеров docker:**
   ```bash
     docker-compose up --build -d
  
4. **Создание .env файла:**

Создайте файл .env с следующим содержимым:
DB_NAME=my_project_db
DB_USER=user_name
DB_PASSWORD=password
DB_ROOT_PASSWORD=password

**База данных (MySQL)**

Файл с командами для создания базы данных находиться в папке ./code.

Для того чтоб у пользователя была возможность редактировать список пользователей, необходимо в таблицу user_rules добавить строку с id пользователя и rule - admin.

## Используемые технологии

**PHP**: Язык программирования для серверной стороны.

**Twig**: Шаблонизатор для создания динамичных HTML-шаблонов.

**Docker**: Для создания и управления контейнерами, обеспечивающих изолированную среду разработки и развертывания.

**MySQL**: Система управления базами данных.

**Composer**: Для управления зависимостями PHP.
