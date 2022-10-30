const {useEffect, useState, Component, useRef} = React;

class Answer extends Component{
    render(){
        const {no, selected, setSelected, answerText, answerImage} = this.props;
        return(
            <div className="uk-card uk-card-default p-m uk-border-rounded m-bottom-m"
                 style={{backgroundColor: selected?'#00ff0030':'#ffffff'}}
                 onClick={()=>{setSelected(selected?null:no)}}>
                <div className="uk-grid uk-grid-small" uk-grid="">
                    <div>
                        <div className="uk-border-circle uk-background-secondary uk-light uk-text-center uk-flex uk-flex-middle uk-flex-center" style={{height: 20, width:20, color:'white', fontSize:11}}>{no}</div>
                    </div>
                    <div className="uk-width-expand">
                        <span dangerouslySetInnerHTML={{ __html: answerText }} />
                        {
                            answerImage!==""?(
                                <img src={answerImage} alt="Question"/>
                            ) :null
                        }
                    </div>
                </div>
            </div>
        )
    }
}

function Question({question, setAnswer,selectedm, review, setReview}){
    const [selecteds, setSelectedS] = useState(selectedm);
    const [reviews, setReviewS] = useState(selectedm);
    const matrix = useRef(null);
    const setSelected = (no)=>{
        setSelectedS(no);
        setAnswer(question.questionId, no, question.examdetailsId);
        if (no==null){setReview(question.questionId, false); setReviewS(false); matrix.current.checked=false }
    }


    return(
        <div className="uk-card uk-card-small uk-card-default uk-card-body uk-margin-small" id={"question_container_"+question.questionId}>
            <span className="uk-text-primary text-m uk-text-bold">Question {question.viewOrder}</span>
            <span className="uk-text-secondary text-s uk-text-bold uk-float-right">Marks: {question.marks} {question.negetive_marks!="0.00"?" ,Negative Marks:"+question.negetive_marks:""}</span>
            <h5 className="uk-margin-small"><span dangerouslySetInnerHTML={{ __html: question.questionText }} /></h5>
            {
                question.questionImage!==""?(
                    <img src={question.questionImage} alt="Question"/>
                ) :null
            }


            <label className="uk-margin-small" style={{visibility: selecteds==null?'collapse':"visible"}}>
                <input ref={matrix} type="checkbox" defaultChecked={reviews} onChange={()=>{setReviewS(!reviews); setReview(question.questionId, !reviews);}}/>Mark Review
            </label>

            <Answer no={1} selected={selecteds===1} setSelected={setSelected} answerText={question.answerText1} answerImage={question.answerImage1}/>
            <Answer no={2} selected={selecteds===2} setSelected={setSelected} answerText={question.answerText2} answerImage={question.answerImage2}/>
            <Answer no={3} selected={selecteds===3} setSelected={setSelected} answerText={question.answerText3} answerImage={question.answerImage3}/>
            <Answer no={4} selected={selecteds===4} setSelected={setSelected} answerText={question.answerText4} answerImage={question.answerImage4}/>

        </div>
    )

}

function Matrix({questionId,viewOrder, selected, review}){
    return(
        <div className="text-m pointable uk-card-outline"
             onClick={()=>{
                 document.querySelector("#question_container_"+questionId).scrollIntoView({behavior: 'smooth'});
             }}
             style={{height: 20, width: 20, display: 'inline-flex', alignItem: 'center', justifyContent: 'center', marginBottom:1, marginRight:1 , backgroundColor: review?'blue':selected?"#00ff0090":"yellow"}}>{viewOrder}</div>
    )

}


const App = (props) =>{
    const [questions, setQuestions] = useState(Object.values(props.questions));
    const [remaining, setRemaining] = useState(props.remaining);
    const [minutes, setMinutes] = useState(0);
    const [seconds, setSeconds] = useState(0);
    const [end, setEnd] = useState(props.end);
    const [matrixShown, setMatrixShown] = useState(false);



    useEffect(()=>{
        socket.on("remaining_time", (res)=>{
            setRemaining(res.remaining_time);
        });
    },[questions]);

    useEffect(()=>{
        if(remaining<0){setRemaining(0); return;};
        if(remaining===0){console.log("exam over"); return;};

        setTimeout(()=>{
            setRemaining(remaining-1);
            var minutes = parseInt(remaining / 60, 10);
            var seconds = parseInt(remaining % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            setMinutes(minutes);
            setSeconds(seconds);
        }, 1000);
    },[remaining]);


    const setAnswer=(qId, no, edId="0")=>{
        let qns = [];
        questions.map((question)=>{
            if(question.questionId===qId){
                question.selected = no;
            }
            qns.push(question);
        });
        setQuestions(qns);

        socket.emit("answer_by_student", {
            examId: props.eId,
            exam_group_id: props.egId,
            studentId: props.sId,
            questionId: qId,
            examdetailsId: edId,
            answer: no>0?no.toString():"",
            historyId: props.hId,

        });

    }
    const setReview=(qId, review)=>{
        let qns = [];
        questions.map((question)=>{
            if(question.questionId==qId){
                question.review = review;
            }
            qns.push(question);
        });
        setQuestions(qns);
    }
    return(
        remaining>0?(
            <>
                <div className="animation-fast" style={{overflow:"hidden",maxHeight: matrixShown?500:0, backgroundColor: "#666666"}}>
                    {
                        questions.map((question) => {
                            return(
                                <Matrix key={"key"+question.questionId}
                                        viewOrder={question.viewOrder}
                                        questionId={question.questionId}
                                        selected={question.selected!=null}
                                        review={question.review}/>
                            )
                        })
                    }

                </div>
                <div className="p-left-m p-right-m uk-position-relative" style={{background: `linear-gradient(to right,  #0000ff90 0%, #ffffff00 80%)`, color: 'white', borderTop: "3px solid #666666"}}>
                    <div onClick={()=>{setMatrixShown(!matrixShown)}} className=" p-left-m p-right-m border-bottom-left-radius-m border-bottom-right-radius-m pointable" style={{position:"absolute", right: 5, top:0, backgroundColor: "#666666"}}>{matrixShown?"Hide":"Show"} Matrix</div>
                    {minutes} : {seconds} Remaining
                </div>
                <div style={{flex: 1, overflowY:'auto'}}>
                    {
                        Object.values(questions).map((question) => {
                            return(
                                <Question key={question.questionId}
                                          question={question}
                                          selected={question.selected}
                                          review = {question.review}
                                          setReview={(questionId, r)=>{
                                              setReview(questionId, r);
                                          }}
                                          setAnswer={(questionId, no)=>{
                                              setAnswer(questionId, no);
                                          }}/>
                            )
                        })
                    }

                    <div>
                        <form action="" method="post" id="submit_form" className="p-m">
                            <input type="submit"
                                   name="submit_paper_button"
                                   value="Final Submit"
                                   className="uk-button uk-button-danger"/>
                            <input type="hidden" name="submit_paper_conform" value="OK" />
                            <hr/>
                            <ul className="uk-text-danger uk-text-small">
                                <li>By submitting you are finally submitting your answer sheet. </li>
                                <li>After submitting you can't change answers. </li>
                                <li>Do not submit your answer sheet if your exam is not complete. </li>
                                <li>Do not refresh this page</li>
                            </ul>
                        </form>
                    </div>
                </div>
            </>
        ):(
            <div>Thank you! Your exam is complete</div>
        )
    )

}
const domContainer = document.querySelector('#examApp');
ReactDOM.render(<App
    questions={questions_ob}
    remaining={remaining_time}
    end={endtime}
    eId={examId}
    sId={studentId}
    hId={historyId}
    egId={exam_group_id}/>, domContainer);
