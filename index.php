<?php
/*
PHP скрипт

На сайте, с большим количеством текстовой информации необходимо реализовать подсветку в тексте ключевых слов
терминов с выводом ссылок на страницу глоссарий терминов.

Задание: необходимо реализовать функцию, которая выделяет в тексте $text ключевые слова из массива $array_of_words
function highlightKeywords($text, $array_of_words), функция должна возвращать обработанный текст.


Дополнительные требования
- выделять нужно только первое вхождение ключевого слова
- не учитывать регистр слов (например, если в массиве есть слово PHP, то необходимо выделять в тексте любое из
вхождений PHP, Php или php)
- выделять нужно только целые ключевые слова, а не подслова (например если в массиве есть ключевое слово HTML,
то слово "HTML5" в тексте не должно выделяться.

Пример
Исходный текст

"Пятая версия PHP была выпущена разработчиками 13 июля 2004 года. Изменения включают обновление ядра Zend
(Zend Engine 2), что существенно увеличило эффективность интерпретатора. Введена поддержка языка разметки XML.
Полностью переработаны функции ООП, которые стали во многом схожи с моделью, используемой в Java. В частности,
введён деструктор, открытые, закрытые и защищённые члены и методы, окончательные члены и методы, интерфейсы и
клонирование объектов. Нововведения, однако, были сделаны с расчётом сохранить наибольшую совместимость с кодом
на предыдущих версиях языка. На данный момент последней стабильной веткой является PHP 5.3, которая содержит ряд
изменений и дополнений"

Слова
'php', 'xml', 'ООП', 'интерфейс', 'Zend'

Ожидаемый результат (фигурными скобками выделены предполагаемые ссылки)
"Пятая версия {{PHP}} была выпущена разработчиками 13 июля 2004 года. Изменения включают обновление ядра {{Zend}}
(Zend Engine 2), что существенно увеличило эффективность интерпретатора. Введена поддержка языка разметки {{XML}}.
Полностью переработаны функции {{ООП}}, которые стали во многом схожи с моделью, используемой в Java. В частности,
введён деструктор, открытые, закрытые и защищённые члены и методы, окончательные члены и методы, интерфейсы и
клонирование объектов. Нововведения, однако, были сделаны с расчётом сохранить наибольшую совместимость с кодом
на предыдущих версиях языка. На данный момент последней стабильной веткой является PHP 5.3, которая содержит ряд
изменений и дополнений"

Дополнительные требования:
1) Оптимизация времени выполнения
2) Функционирование на любой конфигурации PHP, для текстов на любых языках в кодировке UTF-8

Для упрощения можно предположить, что словом в тексте является любая последовательность символов, которая не
 содержит следующие символы:
пробел, табуляция, перевод строки, знаки препинания (.,!?-:;) и скобки (квадратные, круглые, фигурные).
*/



setlocale(LC_ALL, 'ru_RU.65001', 'rus_Rus.65001','Russian_russia', 'russian');

$arr_words = ['php', 'xml', 'ООП', 'интерфейс', 'Zend'];

$text = 'Пятая версия PHP была выпущена разработчиками 13 июля 2004 года. Изменения включают обновление ядра Zend 
(Zend Engine 2), что существенно увеличило эффективность интерпретатора. Введена поддержка языка разметки XML.
 Полностью переработаны функции ООП, которые стали во многом схожи с моделью, используемой в Java. В частности, 
 введён деструктор, открытые, закрытые и защищённые члены и методы, окончательные члены и методы, интерфейсы и 
 клонирование объектов. Нововведения, однако, были сделаны с расчётом сохранить наибольшую совместимость с кодом 
 на предыдущих версиях языка. На данный момент последней стабильной веткой является PHP 5.3, которая содержит ряд
  изменений и дополнений';


function highlightKeywords($text, $array_of_words) {
    foreach ($array_of_words as $word) {

        $text = preg_replace("/\b($word)\b/i", '{{$0}}', $text, 1);
    }
    return $text;
}

echo highlightKeywords($text, $arr_words);

/*
MySQL

Для социальной сети необходим виджет для вывода напоминаний о ближайших днях рождения пользователей
(исключая сегодняшние).

Задание:
Есть таблица пользователей
CREATE TABLE `users` (
`user_id` int(11) NOT NULL default '0',
`birthday` date NOT NULL default '0000-00-00',
`nickname` char(32) NOT NULL default '',
`password` char(32) NOT NULL default '',
PRIMARY KEY (`user_id`)
)
Необходимо написать SQL запрос, который возвращает информацию о 5-ти ближайших днях рождения пользователей
(исключая сегодняшние).

Результат запроса должен содержать поля

`user_id`,
`nickname`,
`day_of_birth` - день рождения (число),
`month_of_birth` - месяц рождения (число),
`age` - достигаемый возраст (число лет),
`interval` - число дней, оставшихся до дня рождения (число)

Ближайший день рождения должен следовать первым в результирующем наборе данных.

Дополнительные требования:
Оптимизация времени выполнения запроса
 */

$SQL = "SELECT user_id, nickname, 
        DAY(birthday) as day_of_birth, 
        MONTH(birthday) as month_of_birth, 
        YEAR(NOW()) - YEAR(birthday) as age, 
        DayOfYear(birthday) - DayOfYear(NOW()) as 'interval'
FROM `person` 
ORDER BY DayOfYear(birthday) > DayOfYear(NOW()) DESC,
		 DayOfYear(birthday) - DayOfYear(NOW()) ASC        
LIMIT 5";





