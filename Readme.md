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
http://localhost/usuario/id
### Edita un usuario PUT
http://localhost/usuario/id/edit

{
    "nombre": "test2",
    "apellido": "test",
    "email": "test@email",
    "sexo": "hombre"
}

### Elimina un usuario DELETE
http://localhost/usuario/id

# Rutas de pedido
### Busca los pedidos por usuario 
http://localhost/pedido/email
