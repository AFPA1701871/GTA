<?php

class PointagesManager
{

	public static function add(Pointages $obj)
	{
		return DAO::add($obj);
	}

	public static function update(Pointages $obj)
	{
		return DAO::update($obj);
	}

	public static function delete(Pointages $obj)
	{
		return DAO::delete($obj);
	}

	public static function findById($id)
	{
		return DAO::select(Pointages::getAttributes(), "Pointages", ["idPointage" => $id])[0];
	}

	public static function getList(array $nomColonnes = null,  array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$nomColonnes = ($nomColonnes == null) ? Pointages::getAttributes() : $nomColonnes;
		return DAO::select($nomColonnes, "Pointages",   $conditions,  $orderBy,  $limit,  $api,  $debug);
	}

	/**
	 * Fonction supprimant de la base de donnée tous les pointages de 0h pour un utilisateur et une période donné
	 *
	 * @param integer $idUtilisateur Utilisateur dont on veut nettoyer les entrées
	 * @param string $periode Période concernée
	 * @return void
	 */
	public static function cleanUp(int $idUtilisateur, string $periode):void{
		$listPointagesPeriode = self::getList(null, ["idUtilisateur"=>$idUtilisateur, "datePointage"=>$periode."%", "nbHeuresPointage"=>0]);
		if(count($listPointagesPeriode)!=0){
			foreach ($listPointagesPeriode as $pointagePartant) {
				self::delete($pointagePartant);
			}
		}
	}
}
