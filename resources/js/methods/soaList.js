import {toOrderBy} from '../utility'

const withStatus = async (page,perPage) => {
    console.log('PER PAGE',perPage)
    const newArray = [];
    const perP = perPage ? perPage : 10
    const {data} = await axios.get(`api/importwithstatus?page=${page}&per_page=${perPage}`);
    // const data = await axios.get(`api/importwithstatus`);

    data.data.forEach((dObj) => {
        const arenaName =
            dObj.arena_name.indexOf("~") > -1
                ? dObj.arena_name.replace(/\~/g, "/")
                : dObj.arena_name;

        const obj = {
            ...dObj,
            arena_name: arenaName,
        };
        newArray.push(obj);
    });

    return {
        withStatusData: toOrderBy(newArray),
        page: data.current_page,
        total: data.total,
        numberOfPages: data.last_page
    };
};

const soa = async (page, perPage) => {

    const {data} = await axios.get(`api/import?page=${page}&per_page=${perPage}`);
    // const data = await axios.get(`api/import`);


    const newArray = [];
    data.data.forEach((dObj) => {
        const arenaName =
            dObj.arena_name.indexOf("~") > -1
                ? dObj.arena_name.replace(/\~/g, "/")
                : dObj.arena_name;

        const obj = {
            ...dObj,
            arena_name: arenaName,
        };
        newArray.push(obj);
    });

    return {
        soaLists: toOrderBy(newArray),
        page: data.current_page,
        total: data.total,
        numberOfPages: data.last_page
    };
};




export { withStatus, soa, };
