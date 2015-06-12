<?php if (!defined('BASEPATH'))     exit('No direct script access allowed');

class mPatient extends CI_Model {

	public function __construct () {
		parent::__construct ();
	}
	
	public function insertNewEntry ($data) {
		if ($this->db->insert ('pasien', $data)){
			return true;
		}
		else return false;
	}
	
	public function getAllEntry () {
		$query = $this->db->get ('pasien');
		if ($query->num_rows> 0) {
			return $query->result_array ();
		} 
		else 
			return null;
	}
	
	public function updateEntry ($data, $id) {
		$this->db->where ('noid_pasien', $id);
		if ($this->db->update ('pasien', $data)) {
			return true;
		}
		else 
		return false;
	}
	
	public function removeEntryById ($id) {
		if ($this->db->delete('pasien', array('ID_PASIEN'=> $id))) {
            return true;
        }
        return false;
	}
	
	public function getEntryByRRM ($id_rrm) {
		$sql = "select temp.*, antrian_unit.WAKTU_ANTRIAN_UNIT from
				(
				select rm.id_rekammedik, rrm.id_riwayat_rm, p.id_pasien, p.noid_pasien, p.nama_pasien, p.alamat_pasien, p.gender_pasien, floor((datediff(curdate(),p.tgl_lahir_pasien)*12) / 365) as umur , sumber_pembayaran_pasien.NAMA_SUMBER_PEMBAYARAN, sumber_pembayaran_pasien.ID_SUMBER
								from
						riwayat_rm rrm left join rekam_medik rm
						on rrm.id_rekammedik = rm.id_rekammedik
						left join pasien p
						on rm.id_pasien = p.id_pasien
						left join sumber_pembayaran_pasien
						on sumber_pembayaran_pasien.ID_SUMBER = rrm.ID_SUMBER
						where rrm.id_riwayat_rm = ".$id_rrm."
				) temp
				left join antrian_unit
				on temp.id_riwayat_rm = antrian_unit.ID_RIWAYAT_RM
				ORDER BY antrian_unit.ID_ANTRIAN_UNIT
				DESC LIMIT 2"
				;
		
		$query = $this->db->query($sql);
		$jumlah_baris = $query->num_rows();
		if ($jumlah_baris > 0) {
			$result = $query->result_array();
			if ($jumlah_baris == 2) {
				return $result[1];
			}
			else {
				$result[0]['WAKTU_ANTRIAN_UNIT'] = '';
				return $result[0];
			}
		}
		else return null;
	}
	
	public function getPatientRI ($id_unit) {
		$sql = 'select pasien.NAMA_PASIEN, rekam_medik.ID_REKAMMEDIK, rawat_inap.* 
		from
		(select data_rawat_inap.*, kategori_tempat_tidur.NAMA_KATEGORI_TT, ruangan_ri.NAMA_RUANGAN_RI, tempat_tidur.NOMOR_TEMPAT_TIDUR 
		from data_rawat_inap
		left join tempat_tidur on data_rawat_inap.ID_TEMPAT_TIDUR = tempat_tidur.ID_TEMPAT_TIDUR
		left join kategori_tempat_tidur on kategori_tempat_tidur.ID_KAT_TT = tempat_tidur.ID_KAT_TT
		left join ruangan_ri on ruangan_ri.ID_RUANGAN_RI = tempat_tidur.ID_RUANGAN_RI
		where data_rawat_inap.FLAG_OPNAME = 1 and ruangan_ri.ID_UNIT = '.$id_unit.') rawat_inap
		left join riwayat_rm on riwayat_rm.ID_RAWAT_INAP = rawat_inap.ID_RAWAT_INAP
		left join rekam_medik on riwayat_rm.ID_REKAMMEDIK = rekam_medik.ID_REKAMMEDIK
		left join pasien on rekam_medik.ID_PASIEN = pasien.ID_PASIEN';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		else return null;
	}
		
}