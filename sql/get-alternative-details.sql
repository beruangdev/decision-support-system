-- Active: 1671565435664@@127.0.0.1@3306@decision_support_system

SELECT
    DISTINCT JSON_KEYS(details)
FROM
    alternatives AS detail_keys;

-- ["kecamatan", "nomor-hp", "rata-rata-pemasukan", "jumlah-anggota-keluarga", "rata-rata-pengeluaran", "luas-lantai", "rata-rata-listrik"]

SELECT *
FROM (
        SELECT
            *,
            json_extract(details, '$.kecamatan') AS kecamatan,
            json_extract(details, '$.nomor-hp') AS `nomor-hp`,
            json_extract(
                details,
                '$.rata-rata-pemasukan'
            ) AS `rata-rata-pemasukan`,
            json_extract(
                details,
                '$.rata-rata-pengeluaran'
            ) AS `rata-rata-pengeluaran`,
            json_extract(
                details,
                '$.jumlah-anggota-keluarga'
            ) AS `jumlah-anggota-keluarga`,
            json_extract(details, '$.luas-lantai') AS `luas-lantai`,
            json_extract(
                details,
                '$.rata-rata-listrik'
            ) AS `rata-rata-listrik`
        FROM alternatives
        limit
            10
    ) AS alternatives;

SELECT
    *,
    json_extract(details, '$.nomor-hp') AS `nomor-hp`,
    json_extract(
        details,
        '$.rata-rata-pemasukan'
    ) AS `rata-rata-pemasukan`,
    json_extract(
        details,
        '$.rata-rata-pengeluaran'
    ) AS `rata-rata-pengeluaran`,
    json_extract(
        details,
        '$.jumlah-anggota-keluarga'
    ) AS `jumlah-anggota-keluarga`,
    json_extract(details, '$.luas-lantai') AS `luas-lantai`,
    json_extract(
        details,
        '$.rata-rata-listrik'
    ) AS `rata-rata-listrik`,
    details ->> "$.kecamatan"
FROM alternatives
WHERE
    JSON_EXTRACT(details, "$.luas-lantai") < 1
limit 10;

SELECT
    details,
FROM alternatives WHERE JSON_CONTAINS(JSON_EXTRACT(details, '$.Luas Lantai'), 11, '$.Luas Lantai');
