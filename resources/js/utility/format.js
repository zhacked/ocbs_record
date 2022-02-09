import numbro from 'numbro';


const numberFormat = (number = 0, decimal = 2) => {
    return numbro(number).format({
        thousandSeparated: true,
        negative: "parenthesis",
        mantissa: decimal
    })
}

const numberUnformat = (string) => {
    return numbro.unformat(string)
}

const moneyFormat = (num, decimals) => num.toLocaleString('en-US', {
	minimumFractionDigits: 2,      
	maximumFractionDigits: 2,
 });


export { numberFormat, numberUnformat, moneyFormat }