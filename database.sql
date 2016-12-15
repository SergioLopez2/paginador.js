create database paginacion
use paginacion

create table usuarios(
  id_usuario int primary key auto_increment, 
  nombres varchar(50) not null,
  apellidos varchar(50) not null
);