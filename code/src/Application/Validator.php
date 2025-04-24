<?php

namespace Alexey\MyProdject\Application;

class Validator {
        
    public static function validate_data($data, $rules): array {
        $errors = [];
        foreach ($rules as $field => $field_rules) {
            // Проверка наличия поля в введенных данных
            if (isset($data[$field])) {
                $value = $data[$field];
    
                // Проверка на пустоту
                if (in_array('required', $field_rules) && empty($value)) {
                    $errors[$field] = ucfirst($field) . ' не может быть пустым.';
                    continue;
                }
    
                // Проверка на наличие HTML-тегов
                if (in_array('no_html', $field_rules) && 
                    preg_match('/<[^<]+>/', $value)) {
                    $errors[$field] = ucfirst($field) . ' не должен содержать HTML-теги.';
                }
    
                // Проверка специфических правил для конкретных полей
                if (in_array('valid_birthday', $field_rules) && 
                    !preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $value)) {
                    $errors[$field] = 'Введите дату рождения в формате ДД-ММ-ГГГГ.';
                }

                if (in_array('valid_email', $field_rules) && 
                    !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value)) {
                    $errors[$field] = 'Неправильный email.';
                }
            } else {
                // Если поле является обязательным, но не передано, добавляем ошибку
                if (in_array('required', $field_rules)) {
                    $errors[$field] = ucfirst($field) . ' не может быть пустым.';
                }
            }
        }
        return $errors;
    }
   
}