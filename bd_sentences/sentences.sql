-- Creacion tabla monedas
CREATE SEQUENCE coins_id_inc;

CREATE TABLE coins (
    id INTEGER NOT NULL DEFAULT nextval('coins_id_inc'),
    name_coins VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);
-- Creacion tabla de materiales
CREATE SEQUENCE materials_id_inc;

CREATE TABLE materials (
    id INTEGER NOT NULL DEFAULT nextval('materials_id_inc'),
    name_materials VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

-- Creacion tabla bodegas
CREATE SEQUENCE store_id_inc;

CREATE TABLE store (
    id INTEGER NOT NULL DEFAULT nextval('store_id_inc'),
    name_store VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

-- Creacion tabla sucursales
CREATE SEQUENCE branch_id_inc;

CREATE TABLE branch (
    id INTEGER NOT NULL DEFAULT nextval('branch_id_inc'),
    name_branch VARCHAR(50) NOT NULL,
    store_id INTEGER NOT NULL REFERENCES store(id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

-- Creacion tabla productos
CREATE SEQUENCE products_id_inc;

CREATE TABLE products (
    id INTEGER NOT NULL DEFAULT nextval('products_id_inc'),
    code VARCHAR(15) UNIQUE NOT NULL,
    name_products VARCHAR(50) NOT NULL,
    store_id INTEGER REFERENCES store(id),
    branch_id INTEGER REFERENCES branch(id),
    coins_id INTEGER REFERENCES coins(id),
    price NUMERIC(10, 2) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
);


-- Relacion tabla materiales y producto
CREATE TABLE materials_products (
    products_id INTEGER REFERENCES products(id) ON DELETE CASCADE,
    materials_id INTEGER REFERENCES materials(id) ON DELETE CASCADE,
    PRIMARY KEY (products_id, materials_id)
);

INSERT INTO store (name_store) VALUES ('Bodega 1'), ('Bodega 2') , ('Bodega 3');

INSERT INTO branch (name_branch, store_id) VALUES ('Sucursal 1', 1), ('Sucursal 2', 1),('Sucursal 3', 2);

INSERT INTO coins (name_coins) VALUES ('Pesos'), ('Dolar'), ('Euro');

INSERT INTO materials (name_materials) VALUES ('Plástico'), ('Metal'), ('Vidrio'), ('Madera'),('Textil');