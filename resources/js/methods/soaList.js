const  withStatus = async (array)=> {
    const data = await axios.get("api/importwithstatus");

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

    return newArray
}

const soa = async () => {
    const data = await axios.get("api/import");

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

    return newArray
}

export {
    withStatus,
    soa
}