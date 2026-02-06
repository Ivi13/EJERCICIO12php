<?php
// app/Modelos/RepositorioCursos.php

require_once __DIR__ . '/ConexionBD.php';
require_once __DIR__ . '/Curso.php';

class RepositorioCursos
{
    private $conexion;

    function __construct()
    {
        $this->conexion = ConexionBD::obtenerConexion();
    }

    // CREATE: insertar un curso
    function insertar($curso)
    {
        $sql = "INSERT INTO cursos (nombre, horas, fecha_creacion)
                VALUES (:nombre, :horas, :fecha)";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':nombre' => $curso->nombre,
            ':horas' => $curso->horas,
            ':fecha' => $curso->fechaCreacion
        ]);
    }

    // READ: obtener todos los cursos
    function obtenerTodos()
    {
        $sql = "SELECT * FROM cursos ORDER BY fecha_creacion DESC";
        $stmt = $this->conexion->query($sql);

        $cursos = [];

        // fetch(PDO::FETCH_ASSOC) devuelve un array asociativo con la fila
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $cursos[] = new Curso(
                $fila['id'],
                $fila['nombre'],
                $fila['horas'],
                $fila['fecha_creacion']
            );
        }

        return $cursos;
    }
}
