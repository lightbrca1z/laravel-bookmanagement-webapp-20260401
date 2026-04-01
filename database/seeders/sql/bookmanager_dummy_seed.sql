-- Dummy data from bookmanager.sql (phpMyAdmin export). Schema must exist (migrations run).
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM `sessions`;

TRUNCATE TABLE `author_book`;
TRUNCATE TABLE `author_details`;
TRUNCATE TABLE `books`;
TRUNCATE TABLE `authors`;
TRUNCATE TABLE `categories`;
TRUNCATE TABLE `users`;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `users` (`id`, `userid`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'テストユーザー', 'test1@bookmanager.local', NULL, '$2y$12$zynH5IrjCVeGr6V8pu45ZuZltGyMNgrIL4PkH8ExPQC7KVv/qPrP2', '6lr10vQTcE2Ttrk4CpIRDxWQVAk7VO7nSuMyO2KQ0FDTVnQK6KYmjftiPbGI', '2026-03-31 17:17:48', '2026-03-31 17:17:48'),
(2, 'test2', 'iwamoto tateatsu', 'test2@gmail.com', NULL, '$2y$12$tmrGfabY6hH98LlURZ6N/.H2rUKHpDelcC3wyLJVcHnUYIqNXMMLu', NULL, '2026-03-31 17:22:12', '2026-03-31 17:22:12');

INSERT INTO `categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'programming', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 'design', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 'management', '2026-03-31 17:18:14', '2026-03-31 17:18:14');

INSERT INTO `authors` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Frida Gulgowski', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 'Crystel Reynolds', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 'Felipe Schmitt', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(4, 'Corbin Funk', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(5, 'Haylie Kemmer', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(6, 'Jessica Baumbach', '2026-03-31 17:18:14', '2026-03-31 17:18:14');

INSERT INTO `author_details` (`author_id`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'letitia.funk@example.net', '5019 Legros Burg\nKleinshire, CA 26399-7151', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 'cullen10@example.net', '28121 Cronin Station Suite 443\nMedhurstburgh, AK 34789-7770', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 'joe.okeefe@example.net', '15936 Klocko Island\nEast Dominiqueland, PA 01798', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(4, 'keebler.nettie@example.com', '95322 Letha Dale\nKelsieside, NV 22380', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(5, 'keith.nicolas@example.net', '3376 Vincenza Heights Apt. 355\nNorth Ray, WV 37633', '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(6, 'bergstrom.cameron@example.org', '918 Sanford River\nSouth Francesside, IL 86166', '2026-03-31 17:18:14', '2026-03-31 17:18:14');

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `isbn`, `price`, `published_at`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dinah my dear! Let.', '井高 舞', '9791209101988', 9762, '2020-06-06', 'Eveniet sint debitis incidunt quam dolorem consequatur. Dolorum dolorem non fugiat facere. Animi laborum reiciendis dicta sunt aliquam consequatur minima aut.\n\nUt dolorum quia accusamus repudiandae. Voluptas hic ipsum eaque cupiditate facilis id tempore. Cum quo temporibus voluptatum amet rerum et veritatis explicabo. Esse quasi molestiae voluptatem repellendus distinctio nisi voluptatem.', 1, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 1, 'I almost think I.', '斉藤 智也', '9795713062384', 3132, '2025-01-11', 'Fuga fugit consequuntur ea at iure. Consequatur saepe maxime ullam deserunt. Facilis possimus quam qui dolorum ea adipisci ut. Ut aliquid natus repellendus repellat hic.\n\nNon atque est qui magnam sint. Eveniet distinctio unde aut deleniti molestias occaecati inventore. Ipsa ex assumenda pariatur nisi fuga fugit.', 1, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 1, 'Alice. \'I\'ve read.', '若松 涼平', '9791721172749', 2091, '2025-12-03', NULL, 2, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(4, 1, 'Five! Always lay.', '山本 亮介', '9780841791787', 9497, '2023-07-14', 'Qui qui quaerat commodi illum veritatis alias. Animi ipsam natus possimus est quia. Ex aliquid praesentium neque sequi.\n\nVoluptatem delectus qui est saepe expedita magni. Labore est possimus ullam dolor quo. Aut nisi sint et suscipit vitae odit modi.', 2, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(5, 1, 'The judge, by the.', '渡辺 美加子', '9788077291279', 4912, '2019-01-11', 'Omnis iste aliquid quasi in. Ut et ad esse facilis. Voluptas iure quia temporibus quam voluptatem. Quo reprehenderit qui quia blanditiis fugiat qui.\n\nFugit et voluptatibus facilis sed nihil. Sint assumenda libero optio incidunt voluptatem at unde aut. Tempore dolorum ullam et autem ipsum modi molestiae. Omnis neque voluptates voluptas ipsum cum.', 3, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(6, 1, 'Gryphon, and the.', '渡辺 春香', '9793184267390', 7605, '2024-09-16', 'Sint quos quae qui id. Dolores quia sunt non non. Facere doloremque consequatur vitae molestiae doloremque distinctio odit saepe. Qui laboriosam expedita nisi ut. Sed quaerat illo est et vitae harum.\n\nNon minima illum eius qui sunt. Iure fugit aperiam eligendi rerum. Ut qui perferendis sunt hic quibusdam.', 3, '2026-03-31 17:18:14', '2026-03-31 17:18:14');

INSERT INTO `author_book` (`book_id`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(1, 5, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 2, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(2, 5, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 2, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(3, 4, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(4, 1, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(4, 6, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(5, 4, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(5, 5, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(6, 2, '2026-03-31 17:18:14', '2026-03-31 17:18:14'),
(6, 6, '2026-03-31 17:18:14', '2026-03-31 17:18:14');

ALTER TABLE `authors` AUTO_INCREMENT = 7;
ALTER TABLE `books` AUTO_INCREMENT = 7;
ALTER TABLE `categories` AUTO_INCREMENT = 4;
ALTER TABLE `users` AUTO_INCREMENT = 3;
