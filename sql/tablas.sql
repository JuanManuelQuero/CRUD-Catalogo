drop table if exists marcas;
drop table if exists moviles;

create table marcas(
    id int AUTO_INCREMENT primary key,
    nombre varchar(80) unique not null,
    img varchar(120) not null,
    ciudad varchar(120) not null
);

create table moviles(
    id int AUTO_INCREMENT primary key,
    modelo varchar(100) not null,
    color varchar(80),
    bateria int,
    marca_id int,
    constraint fk_movil_marca foreign key(marca_id) references marcas(id)
    on delete cascade on update cascade
);