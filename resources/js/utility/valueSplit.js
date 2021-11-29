const valueSplit = (data) => {
        
  
            let target = {};
            let splitpair = data && data.split(': ');
            if(splitpair != undefined) {
                let key = splitpair[0].charAt(0).toLowerCase() + splitpair[0].slice(1).split(' ').join('');
                target[key] = splitpair[1];
            
                return target
            }
         
        
       
    
  
}

export default valueSplit