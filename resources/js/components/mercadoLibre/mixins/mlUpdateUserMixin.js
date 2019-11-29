// Actualiza los datos del usuario en la base de datos a partir de consultas en API de Mercado Libre
import { mapState } from "vuex";
export default {

    data() {
        return {
            userId: '',
            nick: '',
            userMl: {}
        }
    },
    computed: {
        ...mapState(["user_ml", "country_ml", "accessToken", "country_ml"])
    },
    methods: {
        prueba() {
            console.log("Desde Mixin");
        },

        async getUserMl() {

            await axios
                .get("https://api.mercadolibre.com/sites/" + this.country_ml + "/search?nickname=" + this.nick)
                .then(response => {
                    this.userId = response.data.seller.id;
                    // Autorizacion
                    this.obtenerInfoUserMl();
                })
                .catch(e => {
                    console.log(e);
                });

        },
        async obtenerInfoUserMl() {
            console.log(this.userId);
            console.log(this.accessToken);

            await axios
                .get("https://api.mercadolibre.com/users/" + this.userId + "?access_token=" + this.accessToken)
                .then(response => {
                    console.log(response.data);
                    this.userMl = response.data;
                    this.saveInfoUserMl();
                })
                .catch(e => {
                    console.log(e);
                });
        },

        async saveInfoUserMl() {

            // TODO: crear tabla ml_users,
            // make:model -m, make:controller --so???
            // FK a users por id.
            // Si existe el id del sistema, actualizar, sino insertar el resultado

            // Ejemplo post
            axios.post('api/mlusers', {
                ml_id: this.userMl.id,
                nickname: this.userMl.nickname,
                registration_date: this.userMl.registration_date,
                first_name: this.userMl.first_name,
                last_name: this.userMl.last_name,
                gender: this.userMl.gender,
                country_id: this.userMl.country_id,
                email: this.userMl.email,
                identification_number: this.userMl.identification.number,
                identification_type: this.userMl.identification.type,
                address: this.userMl.address.address,
                city: this.userMl.address.city,
                state: this.userMl.address.state,
                zip_code: this.userMl.address.zip_code,
                phone_area_code: this.userMl.phone.area_code,
                phone_extension: this.userMl.phone.extension,
                phone_number: this.userMl.phone.number,
                phone_verified: this.userMl.phone.verified,
                alt_phone_area_code: this.userMl.alternative_phone.area_code,
                alt_phone_extension: this.userMl.alternative_phone.extension,
                alt_phone_number: this.userMl.alternative_phone.number,
                user_type: this.userMl.user_type,
                logo: this.userMl.logo,
                points: this.userMl.points,
                site_id: this.userMl.site_id,
                permalink: this.userMl.permalink,
                seller_experience: this.userMl.seller_experience,
                seller_reputation_level_id: this.userMl.seller_reputation.level_id,
                seller_power_seller_status: this.userMl.seller_reputation.power_seller_status,
                seller_transactions_canceled: this.userMl.seller_reputation.transactions.canceled,
                seller_transactions_completed: this.userMl.seller_reputation.transactions.completed,
                seller_transactions_period: this.userMl.seller_reputation.transactions.period,
                seller_ratings_negative: this.userMl.seller_reputation.transactions.ratings.negative,
                seller_ratings_neutral: this.userMl.seller_reputation.transactions.ratings.neutral,
                seller_ratings_positive: this.userMl.seller_reputation.transactions.ratings.positive,
                seller_transactions_total: this.userMl.seller_reputation.transactions.total
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });

        }
    },
    mounted() {
        this.nick = this.user_ml;
    }
};
