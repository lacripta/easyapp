<?php

namespace models\admin;

class Producto extends \core\Model
{

    /**
     * hace un llamado a un selet de todos los elementos de la tabla de productos
     * @return JSON lista de objetos de la tabla
     */
    public function productos()
    {
        return json_encode($this->_db->select("SELECT * FROM producto;", []));
    }

    /**
     * hace un llamado a un selet de todos los elementos de la tabla de productos
     * @return JSON lista de objetos de la tabla
     */
    public function productos_lista()
    {
        return json_encode($this->_db->select("SELECT *, (select producto_imagen_url from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen, (select producto_imagen_titulo from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen_titulo FROM producto where producto_estado = 1 and producto_destacado = 1;", []));
    }

    /**
     *
     * @param INT $id identificador del producto
     * @return JSON detalles del producto seleccionado
     */
    public function producto($id)
    {
        return $this->_db->select("SELECT producto_categoria,producto_descripcion,producto_grupo,producto_id,producto_nombre,producto_precio,producto_resumen, (select producto_imagen_url from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen, (select producto_imagen_titulo from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen_titulo FROM producto where producto_estado = 1 and producto_id = :id;", [":id" => $id])[0];
    }

    /**
     *
     * @param INT $id identificador del producto
     * @return JSON lista de imagenes disponibles del producto seleccionado
     */
    public function producto_imagenes($id)
    {
        return $this->_db->select("select producto_imagen_url,producto_imagen_titulo,producto_imagen_nombre from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = :id;", [":id" => $id]);
    }

    /**
     *
     * @param STRING $categoria nombre de la categoria filtrada
     * @return JSON lista de prodcutos pertenecientes a la categoria especificada
     */
    public function productos_categoria($categoria)
    {
        return json_encode($this->_db->select("SELECT *, (select producto_imagen_url from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen, (select producto_imagen_titulo from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen_titulo FROM producto where producto_estado = 1 and producto_categoria = :categoria;", [":categoria" => $categoria]));
    }

    /**
     *
     * @return JSON lista de categorias d elos productos ordenadas alfabeticamente
     */
    public function producto_categorias()
    {
        return json_encode($this->_db->select("SELECT * FROM producto_categoria where producto_categoria_estado = 1", []));
    }

    /**
     *
     * @param STRING $categoria nombre de la categoria para encontrar los grupos hijo
     * @return JSON lista de grupos filtrados por el nombre de la categoria, este metodo retorna todos los grupos de la categoria
     */
    public function producto_grupos($categoria)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_grupo where producto_grupo_estado = 1 and producto_grupo_categoria = :categoria", [":categoria" => $categoria]));
    }

    /**
     * metodo que retorna la lista d eproductos filtrados por grupo y categoria
     * @param STRING $categoria nombre de la categoria padre para filtrar los grupos
     * @param STRING $grupo nombre dle grupo perteneciente a una categoria que contiene un set de productos
     * @return JSON lista de productos pertenecientes a la categoria y el grupo antes suministrados
     */
    public function filtro_productos($categoria, $grupo)
    {
        return json_encode($this->_db->select("SELECT *, (select producto_imagen_url from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen, (select producto_imagen_titulo from producto_imagen where producto_imagen_estado = 1 and producto_imagen_producto = producto_id having min(producto_imagen_id)) producto_imagen_titulo FROM producto where producto_estado = 1 and producto_categoria = :categoria and producto_grupo = :grupo;", [":categoria" => $categoria, ":grupo" => $grupo]));
    }

    public function producto_grupo($dato, $categoria)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_grupo where producto_grupo_nombre like :grupo and producto_grupo_categoria = :categoria", [":grupo" => "%" . $dato . "%", ":categoria" => $categoria]));
    }

    /**
     * retorna la lista d elas imagenes pertenecientes al carrusel de la pagina
     * @return JSON lista de elementos de la galeria
     */
    public function elementos_pagina()
    {
        $this->_db->ejecutar("SET @rank=-1;");
        return json_encode($this->_db->select("SELECT if(@rank:=@rank+1 = 0,true,null) AS rank, galeria_url,galeria_descripcion FROM galeria WHERE galeria_estado = 1 ORDER BY galeria_fecha, galeria_estado;", []));
    }

    public function producto_categoria($dato)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_categoria where producto_categoria_nombre like :categoria", [":categoria" => "%" . $dato . "%"]));
    }

    public function producto_nuevo($datos)
    {
        return $this->_db->insert("producto", $datos);
    }

    public function producto_editar($datos, $where)
    {
        return $this->_db->update("producto", $datos, $where);
    }

    public function producto_borrar($datos)
    {
        return $this->_db->delete("producto", $datos);
    }

}
