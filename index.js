// doughnut graph

const chartData={
    labels:["Credit","Debit"],
    data: [credit_per,debit_per],
};


const myChart=document.querySelector(".myChart");
const ul=document.querySelector(".stats .details ul");

new Chart(myChart,{
    type: "doughnut", 
    data:{
        labels: chartData.labels,
        datasets:[
            {
                label: " value in %",
                data: chartData.data,
                backgroundColor:['green','red'],
                borderColor:'#A5C9CA'

            },
        ],
    },
    options:{

        borderWidth:7,
        borderRadius: 5,
        hoverBorderWidth: 0,
        plugins:{
            legend:{
                display:true,
                lables:{
                    font:{
                        family:'Arial',
                        size: 150,
                    },
                },
            }
        },
    },
}) ;

//doughnut graph end

document.getElementById("submit").addEventListener("click",function(){
    document.getElementById("data").submit()
})


