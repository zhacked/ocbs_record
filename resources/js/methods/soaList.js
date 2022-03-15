import {toOrderBy} from '../utility'

const withStatus = async (site,page,perPage, status) => {
    console.log('PER PAGE',perPage)
    const newArray = [];
    const perP = perPage ? perPage : 10
    // const {data} = await axios.get(`api/importwithstatus?page=${page}&per_page=${perPage}`);
    const {data} = await axios.get(`api/importwithstatus?site=${site}&status=done&page=${page}&per_page=${perPage}`);
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

const soa = async (site, page, perPage, status = null) => {
console.log('soaLists>>>',site)
    const {data} = await axios.get(`api/import?site=${site}&status=${status}&page=${page}&per_page=${perPage}`);
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
