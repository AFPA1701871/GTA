USE gta;

INSERT INTO gta_preferences (idPreference, idMotif, idPrestation, idProjet, idUO, idUtilisateur, idTypePrestation) VALUES
(1, 6, 1, 9, 68, 1, 1);
INSERT INTO gta_pointages (idPointage, idMotif, idPrestation, idProjet, idUO, idUtilisateur, idTypePrestation, datePointage, validePointage, reportePointage, nbHeuresPointage) VALUES
(1, 6, 1, 9, 68, 1, 1, '2023-02-14', NULL, NULL, '1.00'),
(2, 6, 1, 9, 68, 1, 1, '2023-02-15', NULL, NULL, '1.00');
INSERT INTO `gta_pointages` (`idPointage`, `idMotif`, `idPrestation`, `idProjet`, `idUO`, `idUtilisateur`, `idTypePrestation`, `datePointage`, `validePointage`, `reportePointage`, `nbHeuresPointage`) VALUES (NULL, '2', '5', '9', '1', '1', '1', '2023-02-14', NULL, NULL, '1');