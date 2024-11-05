-- Crear la base de datos
CREATE DATABASE company_db;

-- Conéctate a la base de datos creada
\c company_db;
-- Ejercicio 1: Creación de Roles Básicos y Privilegios

-- Paso 1: Crear Roles de Usuario
CREATE ROLE admin_user WITH LOGIN SUPERUSER PASSWORD 'admin_password';
CREATE ROLE read_user WITH LOGIN PASSWORD 'read_password';

-- Paso 2: Asignación de Privilegios
ALTER ROLE admin_user CREATEDB CREATEROLE; -- Permisos para admin_user
GRANT CONNECT ON DATABASE company_db TO read_user; -- Conectar a la base de datos

-- Crear una tabla de ejemplo
CREATE TABLE ejemplo (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50)
);

-- Insertar algunos datos en la tabla ejemplo
INSERT INTO ejemplo (nombre) VALUES ('Ejemplo 1'), ('Ejemplo 2');

-- Ejercicio 2: Implementación de Permisos Granulares

-- Paso 1: Creación de la Tabla employees
CREATE TABLE employees (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    departamento VARCHAR(50)
);

-- Paso 2: Definir Permisos Específicos en la Tabla
GRANT SELECT ON employees TO read_user;        -- Permitir SELECT a read_user
REVOKE INSERT, UPDATE, DELETE ON employees FROM read_user; -- Revocar permisos de modificación

-- Insertar datos en la tabla employees para pruebas
INSERT INTO employees (nombre, apellido, departamento) VALUES ('Juan', 'Pérez', 'IT');
INSERT INTO employees (nombre, apellido, departamento) VALUES ('Ana', 'Gómez', 'HR');

-- Ejercicio 3: Administración de Esquemas y Gestión de Roles

-- Paso 1: Crear Esquemas
CREATE SCHEMA hr;
CREATE SCHEMA sales;

-- Paso 2: Crear Tablas en los Esquemas
CREATE TABLE hr.employee_info (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    puesto VARCHAR(50)
);

CREATE TABLE sales.sales_data (
    id SERIAL PRIMARY KEY,
    producto VARCHAR(50),
    cantidad INT
);

-- Paso 3: Configurar Acceso de Esquema por Rol
GRANT ALL PRIVILEGES ON SCHEMA hr TO admin_user; -- Permisos completos para admin_user en hr
GRANT ALL PRIVILEGES ON SCHEMA sales TO admin_user; -- Permisos completos para admin_user en sales
GRANT SELECT ON ALL TABLES IN SCHEMA hr TO read_user; -- Permisos SELECT para read_user en hr
REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA sales FROM read_user; -- Revocar permisos en sales

--Ejercicio 4
-- Crear el rol de grupo manager_role
CREATE ROLE manager_role;

-- Asignar permisos de SELECT y UPDATE en employee_info al rol manager_role
GRANT SELECT, UPDATE ON hr.employee_info TO manager_role;

-- Crear roles individuales manager1 y manager2
CREATE ROLE manager1 WITH LOGIN PASSWORD 'manager1_password';
CREATE ROLE manager2 WITH LOGIN PASSWORD 'manager2_password';

-- Asignarles el rol de grupo manager_role
GRANT manager_role TO manager1;
GRANT manager_role TO manager2;

-- Verificar SELECT
SELECT * FROM hr.employee_info;

-- Verificar UPDATE
UPDATE hr.employee_info SET nombre = 'Nuevo Nombre' WHERE id = 1;  -- Cambia 'Nuevo Nombre' y el id según tus datos