import numbro from 'numbro';


const numberFormat = (number = 0) => {
    return numbro(number).format({
        thousandSeparated: true,
        negative: "parenthesis",
        mantissa: 2
    })
}

const numberUnformat = (string) => {
    return numbro.unformat(string)
}


export { numberFormat, numberUnformat }