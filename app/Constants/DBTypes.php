<?php

namespace App\Constants;

class DBTypes
{
    const UserGender = 'userjk';
    const UserGenderM = 'laki-laki';
    const UserGenderF = 'perempuan';

    const UserRole = 'userrole';
    const RoleSuperAdmin = 'superadmin';
    const RoleAdmin = 'roleadmin';
    const RoleGuruPrem = 'roleguruprem';
    const RoleSiswaPrem = 'rolesiswaprem';
    const RoleGuru = 'roleguru';
    const RoleSiswa = 'rolesiswa';

    const FileTypes = 'fileTypes';
    const FileTypePic = 'fileTypePic';
    const FileProfilePic = 'fileProfPic';
    const FileLessonRps = 'fileLessRps';
    const FileLessonLampiran = 'fileLessLamp';

    const LessonStatus = 'RpsStats';
    const LessonStatusActive = 'RpsStatsActive';
    const LessonStatusNonActive = 'RpsStatsNonActive';
}