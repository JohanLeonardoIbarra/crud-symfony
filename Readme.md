# Rutas de usuario
### Lista los usuarios GET
http://localhost/usuario
### Crea un nuevo usuario POST
http://localhost/usuario/new

{
    "nombre": "test2",
    "apellido": "test",
    "email": "test@email",
    "sexo": "Hombre/Mujer"
}

### Busca un usuario por el id GET
http://localhost/usuario/{email}
### Edita un usuario PUT
http://localhost/usuario/{id}/edit

{
    "nombre": "test2",
    "apellido": "test",
    "email": "test@email",
    "sexo": "Hombre/Mujer"
}

### Elimina un usuario DELETE
http://localhost/user/{id}

# Rutas de pedido
### Busca los pedidos por usuario 
http://localhost/order/list/{email}
### Crea un nuevo pedido
http://localhost/order/new

{
    "email_usuario": "sd@test.com",
    "producto": "Avion",
    "cantidad": 3,
    "precio_unitario": 50
}

### Busca un pedido en especifico
http://localhost/order/{id}
### Elimina un pedido
http://localhost/order/{new}
### Edita un pedido
http://localhost/order/{id}/edit
