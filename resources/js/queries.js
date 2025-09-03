import axios from "axios";

let queries = {
    // action_front: `mutation ($front: front_input) {
    //     front(front: $front) {
    //         error,
    //         message,
    //     }
    // }`,
};

const query = (queryName, queryVariables) => {
    let options = {
        url: "/graphql",
        method: "POST",
        data: {
            query: queries[queryName],
            variables: queryVariables,
        },
    };


    return axios(options);
};

export default query;
