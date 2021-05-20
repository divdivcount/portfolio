package com.kykj.haru2;

import android.annotation.SuppressLint;
import android.content.ClipData;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.GradientDrawable;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import androidx.annotation.RequiresApi;
import androidx.databinding.DataBindingUtil;
import androidx.fragment.app.Fragment;
import androidx.room.Room;
import java.util.*;
import android.os.DropBoxManager;
import android.provider.MediaStore;
import android.renderscript.ScriptGroup;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Toast;
import org.greenrobot.eventbus.EventBus;
import org.greenrobot.eventbus.Subscribe;
import org.greenrobot.eventbus.ThreadMode;
import java.io.File;
import java.util.List;

import static android.app.Activity.RESULT_OK;

public class ForFragment extends Fragment {


    private final int PICTURE_REQUEST_CODE = 200;
    private AppDatabase db;
    private static String title;
    // Store instance variables
    private float startTotal,startTotal2,startTotal3;
    private String result,result2,page, Year, Weather;
    private LinearLayout ibn1;
    private ImageView image1,image2,image3;
    private FrameLayout one_frame,two_frame,three_frame;
    private Button btn1;
    private EditText content;
    private ImageButton one_close, two_close, three_close;
    private Uri uri, urione;
    private ClipData clipData;



    public void onDestroy(){
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void testEvent(FirstFragment.DataEvent event){
        Year = event.helloEventBus;
        System.out.println(Year);
    }

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void testEvent2(SecondFragment.DataEvent event){
        Weather = event.WeatherEventBus;
        System.out.println(Weather);
    }

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void testEvent3(ThirdFragment.DataEvent event){
        startTotal = event.startTotal;
        startTotal2 = event.startTotal2;
        startTotal3 = event.startTotal3;
        System.out.println("-----------------------------");
        Log.d(String.valueOf(startTotal),"Tag4");
        Log.d(String.valueOf(startTotal2),"Tag4");
        Log.d(String.valueOf(startTotal3),"Tag4");
        System.out.println("-----------------------------");
    }

    // newInstance constructor for creating fragment with arguments
    public static ForFragment newInstance(String page, String result) {
        ForFragment fragment = new ForFragment();
        Bundle args = new Bundle();
        args.putString("someInt", page);
        args.putString("formFrag1", result);
        fragment.setArguments(args);
        return fragment;
    }

    // Store instance variables based on arguments passed
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        try{
            EventBus.getDefault().register(this);

        }catch (Exception e){}


    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {

        if(requestCode == PICTURE_REQUEST_CODE)
        {

            if (resultCode == RESULT_OK)
            {
                //기존 이미지 지우기
                image1.setImageResource(0);
                image2.setImageResource(0);
                image3.setImageResource(0);

                //ClipData 또는 Uri를 가져온다
                 uri = data.getData();
                 clipData = data.getClipData();


                //이미지 URI 를 이용하여 이미지뷰에 순서대로 세팅한다.
                if(clipData!=null)
                {
                    System.out.println(clipData.getItemCount()+"몇번");
                    for(int i = 0; i < 3; i++)
                    {
                        if(i<clipData.getItemCount()){
                            urione =  clipData.getItemAt(i).getUri();
                            System.out.println(urione+"cca123");
                            switch (i){
                                case 0:
                                    image1.setImageURI(urione);
                                    one_frame.setVisibility(View.VISIBLE);
                                    break;
                                case 1:
                                    image2.setImageURI(urione);
                                    two_frame.setVisibility(View.VISIBLE);
                                    break;
                                case 2:
                                    image3.setImageURI(urione);
                                    three_frame.setVisibility(View.VISIBLE);
                                    //ibn1.setVisibility(View.GONE);
                                    break;
                            }
                         }
                    }
                }
                else if(uri != null)
                {
                    image1.setImageURI(uri);
                    one_frame.setVisibility(View.VISIBLE);
                }
            }
        }
    }
    // Inflate the view for the fragment based on layout XML
    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_four, container, false);
        one_close = (ImageButton) view.findViewById(R.id.one_close);
        two_close = (ImageButton) view.findViewById(R.id.two_close);
        three_close = (ImageButton) view.findViewById(R.id.three_close);

        ibn1 = (LinearLayout)view.findViewById(R.id.ibn1);
        btn1 = (Button)view.findViewById(R.id.btn1);
        one_frame = (FrameLayout)view.findViewById(R.id.one_frame);
        two_frame = (FrameLayout)view.findViewById(R.id.two_frame);
        three_frame = (FrameLayout)view.findViewById(R.id.three_frame);

        image1 = (ImageView)view.findViewById(R.id.first_img);
        image2 = (ImageView)view.findViewById(R.id.second_img);
        image3 = (ImageView)view.findViewById(R.id.third_img);

        GradientDrawable drawable = (GradientDrawable) getResources().getDrawable(R.drawable.shape2);
        image1.setBackground(drawable);
        image1.setClipToOutline(true);
        image2.setBackground(drawable);
        image2.setClipToOutline(true);
        image3.setBackground(drawable);
        image3.setClipToOutline(true);


        ibn1.setOnClickListener(new View.OnClickListener() {
            @SuppressLint("IntentReset")
            @RequiresApi(api = Build.VERSION_CODES.JELLY_BEAN_MR2)
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(Intent.ACTION_OPEN_DOCUMENT, MediaStore.Audio.Media.EXTERNAL_CONTENT_URI);
                //사진을 여러개 선택할수 있도록 한다
                intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true);
                intent.setType("image/*");
                startActivityForResult(Intent.createChooser(intent, "Select Picture"),  PICTURE_REQUEST_CODE);
                Toast.makeText(getActivity(),"사진은 3장만 가능합니다.", Toast.LENGTH_SHORT).show();
            }
        });
        btn1 = (Button)view.findViewById(R.id.btn1);
        content = (EditText)view.findViewById(R.id.content);
        image1.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View view) {
                one_close.setVisibility(View.VISIBLE);
                return false;
            }
        });
        one_close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                image1.setImageResource(0);
                one_frame.setVisibility(View.GONE);
                one_close.setVisibility(View.GONE);
                //ibn1.setVisibility(View.VISIBLE);
            }
        });

        image2.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View view) {
                two_close.setVisibility(View.VISIBLE);
                return false;
            }
        });
        two_close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                image2.setImageResource(0);
                two_frame.setVisibility(View.GONE);
                two_close.setVisibility(View.GONE);
               // ibn1.setVisibility(View.VISIBLE);
            }
        });

        image3.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View view) {
                three_close.setVisibility(View.VISIBLE);
                return false;
            }
        });
        three_close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                image3.setImageResource(0);
                three_frame.setVisibility(View.GONE);
                three_close.setVisibility(View.GONE);
                //ibn1.setVisibility(View.VISIBLE);
            }
        });
        view.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {

                InputMethodManager imm = (InputMethodManager)getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(content.getWindowToken(), 0);
                return false;
            }
        });
        btn1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String text = Year;
                String pattern = "^[0-9][0-9][0-9][0-9]\\.[0-9][0-9]\\.[0-9][0-9]$"; // ^시작,$끝
                if (!text.matches(pattern)) {// (년도-월-일) 의 패턴으로 넘어오는지 체크
                    Toast.makeText(getActivity(),"날짜를 잘못 쓰셨어요! 첫 페이지를 확인해주세요 :)", Toast.LENGTH_SHORT).show();
                }else{
                    Todo todo = new Todo();
                    todo.setYear(Year.replace("\n",""));
                    todo.setContent(content.getText().toString());
                    if(Weather == null){
                        Toast.makeText(getActivity(),"날씨가 선택되지 않았어요! 두 번째 페이지를 확인해주세요 :)", Toast.LENGTH_SHORT).show();
                    }else{
                        todo.setWeather(Weather);
                        todo.setStar_three(startTotal3);
                        todo.setStar_two(startTotal2);
                        todo.setStar_one(startTotal);
                        if(clipData!=null)
                        {

                            for(int i = 0; i < 3; i++)
                            {
                                if(i<clipData.getItemCount()){
                                    urione =  clipData.getItemAt(i).getUri();
                                    switch (i){
                                        case 0:
                                            todo.setImgname1(urione.toString());
                                            break;
                                        case 1:
                                            todo.setImgname2(urione.toString());
                                            break;
                                        case 2:
                                            todo.setImgname3(urione.toString());
                                            break;
                                    }
                                }
                            }
                        }
                        else if(uri != null)
                        {
                            todo.setImgname1(uri.toString());
                        }
                        db.todoDao().insert(todo);
                    }
                }
            }
        });
        db = Room.databaseBuilder(getActivity(),AppDatabase.class, "todo-db").allowMainThreadQueries().build();
        fetch();
        return view;
    }


    private void fetch(){
        List<Todo> list = (List<Todo>) db.todoDao().getAll();
        List<String> dateArray = new ArrayList<String>();
        String list_one = "목록";
        for(Todo todo : list){

                dateArray.add(todo.getYear());
                Collections.sort(dateArray);
                System.out.println("DATE " + dateArray);
            list_one += "\n"+ dateArray +", "+ todo.getWeather() +", " + todo.getContent() +", " + todo.getStar_one() +", " + todo.getStar_two()+", "  + todo.getStar_three()+", "+todo.getImgname1()+", "+todo.getImgname2()+", "+todo.getImgname3();
        }
    }

}
