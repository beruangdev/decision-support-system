window.ahp = ahp
function ahp({ values }) {
    return {

        ri: [
            0,
            0,
            0.58,
            0.9,
            1.12,
            1.24,
            1.32,
            1.41,
            1.45,
            1.49,
        ],
        values,
        length: 0,
        values_rotate: [],
        eigen_vektor_normalisasi: {
            results: []
        },
        normalisasi: {
            values: [],
            weight: [],
            p: [],
            v: [],
        },
        values_normal_weight: {
            values: [],
            totals: []
        },
        lambda: 0,
        ci: 0,
        cr: 0,

        init() {
            this.values_rotate = this.rotate_array(this.values)
            this.length = this.values[0].length

            this.$eigen_vektor_normalisasi()

            this.$normalisasi_value()
            this.$normalisasi_weight()
            this.$normalisasi_p()
            this.$normalisasi_v()

            this.$values_normal_weight()
            this.$lambda()
            this.$ci()
            this.$cr()
        },
        $eigen_vektor_normalisasi() {
            this.eigen_vektor_normalisasi.results = this.sum_array(this.values_rotate)
        },
        $normalisasi_value() {
            let normalisasi_values = this.values_rotate.map((value_rotate, index1) => {
                return value_rotate.map((value, index2) => {
                    return value / this.eigen_vektor_normalisasi.results[index1]
                })
            })
            this.normalisasi.values = this.rotate_array(normalisasi_values)
        },
        $normalisasi_weight() {
            let datas = this.normalisasi.values
            this.normalisasi.weight = this.sum_array(datas)
            this.normalisasi.weight = this.normalisasi.weight.map(weight => weight / this.length)
        },
        $normalisasi_p() {
            let normalisasi_p = [];
            this.values.forEach((value, index1) => {
                normalisasi_p.push([])
                value.forEach((vv, index2) => {
                    normalisasi_p[index1].push(vv * this.normalisasi.weight[index2])
                })
            });
            this.normalisasi.p = this.sum_array(normalisasi_p)
        },
        $normalisasi_v() {
            this.normalisasi.v = this.normalisasi.p.map((np, index) => {
                return np / this.normalisasi.weight[index]
            })
        },
        $values_normal_weight() {
            this.values_normal_weight.values = this.values.map((value, index1) => {
                return value.map((vv, index2) => {
                    return vv * this.normalisasi.weight[index2]
                })
            })
            
            
            this.values_normal_weight.totals = this.sum_array(this.values_normal_weight.values)
        },
        $lambda() {
            this.lambda = this.values_normal_weight.totals.reduce((accumulator, value) => {
                return accumulator + value;
            }, 0);
        },
        $ci() {
            this.ci = (this.lambda - this.length) / (this.length - 1)
        },
        $cr() {
            this.cr = this.ci / this.get_ri()
        },
        get(data) {
            return JSON.parse(JSON.stringify(data))
        },
        rotate_array(array) {
            let new_array = []
            array.forEach((data1, index1) => {
                new_array.push([])
                array.forEach((data2, index2) => {
                    new_array[index1].push(data2[index1])
                });
            });
            return new_array
        },
        sum_array(array) {
            let results = []
            array.forEach(rv => {
                let result = rv.reduce((accumulator, value) => {
                    return accumulator + value;
                }, 0);
                results.push(result)
            })
            return results
        },
        get_ri() {
            let index = this.ri.length - 1
            let length = this.length
            if (length <= this.ri.length) index = length - 1
            return this.ri[index]
        },
    }
}
