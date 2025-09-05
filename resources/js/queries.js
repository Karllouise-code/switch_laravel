import axios from "axios";
import CryptoJS from "crypto-js";

let queries = {
    action_user: `mutation ($user: user_input) {
        user(user: $user) {
            error,
            message,
            access_token
        }
    }`,

    user: `query ($action_type: String) {
        user(action_type: $action_type) {
            name,
            email,
        }
    }`,
};


const userQueries = ["user"];

const getApiUrl = (queryName) => {
    let segment = "";

    if (userQueries.some((q) => q === queryName)) {
        segment = "/user";
    }

    return `/graphql${segment}`;
};

const query = (queryName, queryVariables) => {
    var token = '';
    if (userQueries.some((q) => q === queryName)) {
        var secret_passphrase = process.env.MIX_SECRET_PASSPHRASE;
        const encryptedToken = sessionStorage.getItem("access-token");
        token = CryptoJS.AES.decrypt(encryptedToken, secret_passphrase).toString(CryptoJS.enc.Utf8);
    }
    
    let options = {
        // url: "/graphql",
        url: getApiUrl(queryName),
        method: "POST",
        data: {
            query: queries[queryName],
            variables: queryVariables,
        },
    };
    

    if (token) {
        options.headers = {
            Authorization: `Bearer ${token}`,
        };
    }

    return axios(options);
};

export default query;
