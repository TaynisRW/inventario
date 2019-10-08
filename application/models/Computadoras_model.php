<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Computadoras_model extends CI_Model {

	public function getComputadoras($estado = false,$search,$fechainicio = false, $fechafinal =false, $ip = 0){
		

		$this->db->select("c.*,p.nombre as presentacion, pro.nombre as proveedor, f.nombre as finca, fa.nombre as fabricante,pr.referencia,pr.velocidad,m.capacidad as memoria,d.capacidad as disco,o.nombre as office,s.descripcion as sistema,ant.descripcion as antivirus,a.nombre as area,mo.codigo as monitor,u.nombres, ip.descripcion as direccionIP, prop.nombre, prop.apPat, prop.apMat");
		$this->db->from("computadoras c");
		$this->db->join("monitores mo","c.monitor_id = mo.id","Left");
		$this->db->join("presentaciones p","c.presentacion_id = p.id","Left");
		$this->db->join("proveedores pro","c.proveedor_id = pro.id","Left");
		$this->db->join("elemento f","c.finca_id = f.id","Left");
		$this->db->join("fabricantes fa","c.fabricante_id = fa.id","Left");
		$this->db->join("procesadores pr","c.procesador_id = pr.id","Left");
		$this->db->join("memorias m","c.ram_id = m.id","Left");
		$this->db->join("propietarios prop","c.id_propietario = prop.id","Left");
		$this->db->join("discos d","c.disco_id = d.id","Left");
		$this->db->join("sistemas s","c.so_id = s.id","Left");
		$this->db->join("office o","c.office_id = o.id","Left");
		$this->db->join("antivirus ant","c.antivirus_id = ant.id","Left");
		$this->db->join("areas a","c.area_id = a.id","Left");
		$this->db->join("usuarios u","c.usuario_id = u.id","Left");
		$this->db->join("ip","c.ip_id = ip.id","Left");

		if ($fechainicio !== false && $fechafinal !== false) {
			$this->db->where("c.fecregistro >=", $fechainicio." "."00:00:00");
			$this->db->where("c.fecregistro <=", $fechafinal." "."23:59:59");

		}
		if ($ip == 1) {
			$this->db->where("ip.estado",0);
		}
		if ($estado != false) {
			$this->db->where("c.estado",1);
		}
		$this->db->like("CONCAT(c.codigo, '', f.nombre, '', a.nombre,'',pr.velocidad,'',d.capacidad,'',m.capacidad,'',mo.codigo,'',c.serial_so,'',u.nombres)",$search);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function infoComputadora($id){
		$this->db->select("c.*,p.nombre as presentacion, pro.nombre as proveedor, f.nombre as finca, fa.nombre as fabricante,pr.referencia,pr.velocidad,m.capacidad as memoria,d.capacidad as disco,o.nombre as office,s.descripcion as sistema,ant.descripcion as antivirus,a.nombre as area,a.nombre as area,mo.codigo as monitor, ip.descripcion as direccionIP, prop.*");
		$this->db->from("computadoras c");
		$this->db->join("monitores mo","c.monitor_id = mo.id","Left");
		$this->db->join("presentaciones p","c.presentacion_id = p.id","Left");
		$this->db->join("proveedores pro","c.proveedor_id = pro.id","Left");
		$this->db->join("elemento f","c.finca_id = f.id","Left");
		$this->db->join("propietarios prop","c.id_propietario = prop.id","Left");
		$this->db->join("fabricantes fa","c.fabricante_id = fa.id","Left");
		$this->db->join("procesadores pr","c.procesador_id = pr.id","Left");
		$this->db->join("memorias m","c.ram_id = m.id","Left");
		$this->db->join("discos d","c.disco_id = d.id","Left");
		$this->db->join("sistemas s","c.so_id = s.id","Left");
		$this->db->join("office o","c.office_id = o.id","Left");
		$this->db->join("antivirus ant","c.antivirus_id = ant.id","Left");
		$this->db->join("areas a","c.area_id = a.id","Left");
		$this->db->join("ip","c.ip_id = ip.id","Left");
		$this->db->where("c.id", $id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function save($data){
		return $this->db->insert("computadoras",$data);
	}

	public function getComputadora($id){
		$this->db->where("id", $id);
		$resultados = $this->db->get("computadoras");
		return $resultados->row();
	}

	public function update($id,$data){
		$this->db->where("id", $id);
		return $this->db->update("computadoras",$data);
	}

	public function delete($id){
		$this->db->where("id", $id);
		return $this->db->delete("computadoras");
	}

	public function saveMante($data){
		return $this->db->insert("computadoras_mantenimientos",$data);
	}

	public function savePropietario($data){
		return $this->db->insert("computadoras",$data);
	}

	public function getMantenimientos($id){
		
		$this->db->where("computadora_id",$id);
		
		$resultados = $this->db->get("computadoras_mantenimientos");
		return $resultados->result();
	}

	public function getPropietarios($id){
		
		$this->db->where("id_propietario",$id);
		
		$resultados = $this->db->get("propietarios");
		return $resultados->result();
	}


}