-- Active: 1671565435664@@127.0.0.1@3306@decision_support_system
SELECT a.*
    ,MAX(IF(at.key_slug = 'jumlah-anggota-keluarga', at.value, NULL)) as jumlah_anggota_keluarga
    ,MAX(IF(at.key_slug = 'jumlah-rata-rata-pengeluaran-bulanan', at.value, NULL)) as jumlah_rata_rata_pengeluaran_bulanan
    ,MAX(IF(at.key_slug = 'luas-lantai-perkapita', at.value, NULL)) as luas_lantai_perkapita
FROM alternatives a
LEFT JOIN alternative_taxonomies AS at ON a.id = at.alternative_id
-- WHERE 'jumlah-anggota-keluarga' = "2"
-- WHERE a.name="Padmi Astuti"
GROUP BY a.id
;

SELECT DISTINCT key_slug FROM alternative_taxonomies;

SELECT * FROM ( SELECT a.* ,MAX(IF(at.key_slug = 'jumlah-anggota-keluarga', at.value, NULL)) as `jumlah-anggota-keluarga` ,MAX(IF(at.key_slug = 'jumlah-rata-rata-pengeluaran-bulanan', at.value, NULL)) as `jumlah_rata_rata_pengeluaran_bulanan` ,MAX(IF(at.key_slug = 'luas-lantai-perkapita', at.value, NULL)) as `luas_lantai_perkapita` FROM alternatives a LEFT JOIN alternative_taxonomies AS at ON a.id = at.alternative_id GROUP BY a.id ) AS alternatives 
WHERE `jumlah-anggota-keluarga`<=2

;
