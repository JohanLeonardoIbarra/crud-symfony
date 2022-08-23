# Rutas de usuario
### Lista los usuarios GET
http://localhost/usuario
### Crea un nuevo usuario POST
http://localhost/usuario/new

{
    "nombre": "test2",
    "apellido": "test",
    "email": "test@email",
    "sexo": "hombre"
}

### Busca un usuario por el id GET
http://localhost/usuario/{email}
### Edita un usuario PUT
http://localhost/usuario/{id}/edit

{
    "nombre": "test2",
    "apellido": "test",
    "email": "test@email",
    "sexo": "hombre"
}

### Elimina un usuario DELETE
http://localhost/usuario/{id}

# Rutas de pedido
### Busca los pedidos por usuario 
http://localhost/pedido/list/{email}
### Crea un nuevo pedido
http://localhost/pedido/new

{
    "email_usuario": "sd@test.com",
    "producto": "Avion",
    "cantidad": 3,
    "precio_unitario": 50
}

### Busca un pedido en especifico
http://localhost/pedido/{id}
### Elimina un pedido
http://localhost/pedido/{new}
### Edita un pedido
http://localhost/pedido/{id}/edit
