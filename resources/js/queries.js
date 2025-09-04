import axios from "axios";

let queries = {
    action_user: `mutation ($user: user_input) {
        user(user: $user) {
            error,
            message,
            access_token
        }
    }`,
};


// const userQueries = [""];

// const getApiUrl = (queryName) => {
//     let segment = "";

//     if (userQueries.some((q) => q === queryName)) {
//         segment = "/users";
//     }

//     return `/graphql${segment}`;
// };

const query = (queryName, queryVariables) => {
    // if (userQueries.some((q) => q === queryName)) {
    //     var secret_passphrase = process.env.MIX_SECRET_PASSPHRASE;
    //     var token = "";
    //     const encryptedToken = sessionStorage.getItem("uat");
    //     token = CryptoJS.AES.decrypt(encryptedToken, secret_passphrase).toString(CryptoJS.enc.Utf8);
    // }
    
    let options = {
        url: "/graphql",
        method: "POST",
        data: {
            query: queries[queryName],
            variables: queryVariables,
        },
    };

    // if (token) {
    //     options.headers = {
    //         Authorization: `Bearer ${token}`,
    //     };
    // }


    return axios(options);
};

export default query;
