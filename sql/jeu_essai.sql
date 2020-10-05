INSERT INTO comments
    VALUES (NULL,'1', 'John Doe', 'Oat cake oat cake pastry I love pudding pie jelly marzipan. Gummies candy canes oat cake cake. Topping pudding powder chocolate ice cream powder tiramisu liquorice I love.
I love bonbon pudding candy fruitcake ice cream ice cream sugar plum dragée. Danish cotton candy I love oat cake biscuit. I love gummi bears jelly-o topping caramels wafer brownie dessert jelly. Cotton candy jelly beans liquorice marshmallow chocolate cake wafer.', '2020-09-27');

INSERT INTO posts
    VALUES (NULL, 'Dessert icing fruitcake', 'Sesame snaps I love liquorice tootsie roll halvah jelly beans jelly candy marzipan. Sesame snaps macaroon tootsie roll cookie. Pie chocolate bar chocolate bar ice cream I love lollipop chocolate bar.', '2020-09-15');


INSERT INTO `comments` (`id`, `idPost`, `author`, `comment`, `dateComment`) VALUES
(NULL, 1, 'M@teo21', 'Un peu court ce billet !', '2010-03-25 16:49:53'),
(NULL, 1, 'Maxime', 'Oui, ça commence pas très fort ce blog...', '2010-03-25 16:57:16'),
(NULL, 1, 'MultiKiller', '+1 !', '2010-03-25 17:12:52'),
(NULL, 2, 'John', 'Preum''s !', '2010-03-27 18:59:49'),
(NULL, 2, 'Maxime', 'Excellente analyse de la situation !\r\nIl y arrivera plus tôt qu''on ne le pense !', '2010-03-27 22:02:13');

INSERT INTO `posts` (`id`, `titre`, `contenu`, `dateCreation`) VALUES
(1, 'Bienvenue sur mon blog !', 'Je vous souhaite à toutes et à tous la bienvenue sur mon blog qui parlera de... PHP bien sûr !', '2010-03-25 16:28:41'),
(2, 'Le PHP à la conquête du monde !', 'C''est officiel, l''éléPHPant a annoncé à la radio hier soir "J''ai l''intention de conquérir le monde !".\r\nIl a en outre précisé que le monde serait à sa botte en moins de temps qu''il n''en fallait pour dire "éléPHPant". Pas dur, ceci dit entre nous...', '2010-03-27 18:31:11');
