-- ARBORESCENCE
HOME : page d'acueil du blog 
ABOUT : biographie de l'auteur
POST : liste l'ensemble des postes
CONTACT : pour plus de question

-- DATABASE
USER [
    id int auto increment,
    username varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    image varchar(255) not null,
    roles json not null,
    primary key (id)
]

ABOUT [
    id in auto increment,
    title varchar(255) not null,
    content text not null,
    image_name varchar(255) not null,
    updated_at datetime_immutable not null,
    primary key (id)
]

POST [
    id int auto increment,
    user_id(author) int not null,
    title varchar(255) not null,
    slug varchar(255) not null
    summary text null,
    content text not null,
    image_name varchar(255) not null,
    created_at datetime_immutable not null,
    published_at datetime_immutable not null,
    updated_at datetime_immutable not null,
    is_published boolean,
    primary key (id)
]

CATEGORY [
    id int auto increment,
    name varchar(255) not null,
    slug varchar(255) not null,
    primary key (id)
]

COMMENT [
    id int auto increment,
    post_id int not null,
    username varchar(255) not null,
    email varchar(255) not null,
    content text not null,
    published_at datetime_immutable not null,
    primary key (id)
]

POST_CATEGORY [
    post_id int auto increment,
    category_id int auto increment,
    primary key (post_id, category_id),
    constraint fk_post
        foreign key (post_id)
        references post (id)
        on update cascad
        on delete restrict,
    constraint fk_category
        foreign key (category_id)
        references category (id)
        on update cascad
        on delete restrict
]

Liaison :
chaque utilisateur peut poster un ou plusieur commentaire
chaque commentaire est poster par un et un seul utilisateur

chaque commentaire est lié à un post
chaque post peut avoir un ou plusieur commentaires

chaque catégorie est lié à un ou plusieur post 
chaque post est lié à un ou plusieur categorie


