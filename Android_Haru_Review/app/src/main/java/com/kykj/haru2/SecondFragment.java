package com.kykj.haru2;

import android.graphics.Typeface;
import android.graphics.fonts.Font;
import android.os.Build;
import android.os.Bundle;

import androidx.annotation.RequiresApi;
import androidx.fragment.app.Fragment;

import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import org.greenrobot.eventbus.EventBus;

@RequiresApi(api = Build.VERSION_CODES.O)
public class SecondFragment extends Fragment {
    // Store instance variables
//    private Spinner spinner;
//    private static final String[] menu = new String[]{"•화창했어요", "•비가 왔어요", "•구름이 많았어요","•눈이 왔어요","•천둥번개가 쳤어요"};
    private TextView today_weather_two ,son, rain, snow, cloud, bunge, last, end;
    private ImageView w_son, w_rain, w_snow, w_cloud, w_bunge;
    // newInstance constructor for creating fragment with arguments
    public static class DataEvent {

        public final String WeatherEventBus;

        public DataEvent(String WeatherEventBus) {
            this.WeatherEventBus = WeatherEventBus;
        }
    }

    public void onDestroy(){
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }


    public static SecondFragment newInstance(int page, String title) {
        SecondFragment fragment = new SecondFragment();
        Bundle args = new Bundle();
        args.putInt("someInt", page);
        args.putString("someTitle", title);
        fragment.setArguments(args);
        return fragment;
    }

    // Store instance variables based on arguments passed
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


    }

    // Inflate the view for the fragment based on layout XML
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_second, container, false);

        son = (TextView)view.findViewById(R.id.son);
        rain = (TextView)view.findViewById(R.id.rain);
        snow = (TextView)view.findViewById(R.id.snow);
        cloud = (TextView)view.findViewById(R.id.cloud);
        bunge = (TextView)view.findViewById(R.id.bunge);
        today_weather_two = (TextView)view.findViewById(R.id.today_weather_two);
        last = (TextView)view.findViewById(R.id.last);
        end = (TextView)view.findViewById(R.id.end);

        w_son = (ImageView)view.findViewById(R.id.w_son);
        w_rain = (ImageView)view.findViewById(R.id.w_rain);
        w_snow = (ImageView)view.findViewById(R.id.w_snow);
        w_cloud = (ImageView)view.findViewById(R.id.w_cloud);
        w_bunge = (ImageView)view.findViewById(R.id.w_bunge);

        son.setOnClickListener(new View.OnClickListener() {
            int s = 0;

            @Override
            public void onClick(View view) {
                if(s == 1){
                    w_son.setVisibility(View.GONE);

                    last.setVisibility(View.GONE);
                    end.setVisibility(View.GONE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,40 ,0,0);
                    son.setLayoutParams(lp);
                    son.setText("•화창했어요");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    son.setTypeface(typeface);
                    son.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 28);

                    rain.setVisibility(View.VISIBLE);
                    snow.setVisibility(View.VISIBLE);
                    cloud.setVisibility(View.VISIBLE);
                    bunge.setVisibility(View.VISIBLE);
                    today_weather_two.setVisibility(View.VISIBLE);
                    s = 0;
                }else{
                    s = s + 1;
                    w_son.setVisibility(View.VISIBLE);
                    last.setVisibility(View.VISIBLE);
                    end.setVisibility(View.VISIBLE);

                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,0 ,0,0);

                    LinearLayout.LayoutParams top = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    top.setMargins(0,10,0,0);
                    son.setLayoutParams(lp);
                    w_son.setLayoutParams(top);
                    son.setText("화창했어요.");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    son.setTypeface(typeface);
                    son.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 36);

                    rain.setVisibility(View.GONE);
                    snow.setVisibility(View.GONE);
                    cloud.setVisibility(View.GONE);
                    bunge.setVisibility(View.GONE);
                    today_weather_two.setVisibility(View.GONE);
                    EventBus.getDefault().post(new SecondFragment.DataEvent(son.getText().toString()));

                }
            }
        });
        rain.setOnClickListener(new View.OnClickListener() {
            int s = 0;
            @Override
            public void onClick(View view) {
                if(s == 1){
                    w_rain.setVisibility(View.GONE);

                    last.setVisibility(View.GONE);
                    end.setVisibility(View.GONE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,40 ,0,0);
                    rain.setLayoutParams(lp);
                    rain.setText("•비가 왔어요");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    rain.setTypeface(typeface);
                    rain.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 28);

                    son.setVisibility(View.VISIBLE);
                    snow.setVisibility(View.VISIBLE);
                    cloud.setVisibility(View.VISIBLE);
                    bunge.setVisibility(View.VISIBLE);
                    today_weather_two.setVisibility(View.VISIBLE);
                    s = 0;
                }else{
                    s = s + 1;
                    w_rain.setVisibility(View.VISIBLE);

                    last.setVisibility(View.VISIBLE);
                    end.setVisibility(View.VISIBLE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,0 ,0,0);

                    LinearLayout.LayoutParams top = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    top.setMargins(0,10,0,0);
                    rain.setLayoutParams(lp);
                    w_rain.setLayoutParams(top);
                    rain.setText("비가 왔어요.");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    rain.setTypeface(typeface);
                    rain.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 36);

                    son.setVisibility(View.GONE);
                    snow.setVisibility(View.GONE);
                    cloud.setVisibility(View.GONE);
                    bunge.setVisibility(View.GONE);
                    today_weather_two.setVisibility(View.GONE);
                    EventBus.getDefault().post(new SecondFragment.DataEvent(rain.getText().toString()));
                }
            }
        });
        cloud.setOnClickListener(new View.OnClickListener() {
            int s = 0;

            @Override
            public void onClick(View view) {
                if(s == 1){
                    w_cloud.setVisibility(View.GONE);

                    last.setVisibility(View.GONE);
                    end.setVisibility(View.GONE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,40 ,0,0);
                    cloud.setLayoutParams(lp);
                    cloud.setText("•흐렸어요");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    cloud.setTypeface(typeface);
                    cloud.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 28);

                    son.setVisibility(View.VISIBLE);
                    snow.setVisibility(View.VISIBLE);
                    rain.setVisibility(View.VISIBLE);
                    bunge.setVisibility(View.VISIBLE);
                    today_weather_two.setVisibility(View.VISIBLE);
                    s = 0;
                }else{
                    s = s + 1;
                    w_cloud.setVisibility(View.VISIBLE);

                    last.setVisibility(View.VISIBLE);
                    end.setVisibility(View.VISIBLE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,0 ,0,0);

                    LinearLayout.LayoutParams top = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    top.setMargins(0,10,0,0);
                    cloud.setLayoutParams(lp);
                    w_cloud.setLayoutParams(top);
                    cloud.setText("흐렸어요.");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    cloud.setTypeface(typeface);
                    cloud.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 36);

                    son.setVisibility(View.GONE);
                    rain.setVisibility(View.GONE);
                    snow.setVisibility(View.GONE);
                    bunge.setVisibility(View.GONE);
                    today_weather_two.setVisibility(View.GONE);
                    EventBus.getDefault().post(new SecondFragment.DataEvent(cloud.getText().toString()));
                }
            }
        });
        snow.setOnClickListener(new View.OnClickListener() {
            int s = 0;
            @Override
            public void onClick(View view) {
                if(s == 1){
                    w_snow.setVisibility(View.GONE);

                    last.setVisibility(View.GONE);
                    end.setVisibility(View.GONE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,40 ,0,0);
                    snow.setLayoutParams(lp);
                    snow.setText("•눈이 왔어요");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    snow.setTypeface(typeface);
                    snow.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 28);

                    son.setVisibility(View.VISIBLE);
                    cloud.setVisibility(View.VISIBLE);
                    rain.setVisibility(View.VISIBLE);
                    bunge.setVisibility(View.VISIBLE);
                    today_weather_two.setVisibility(View.VISIBLE);
                    s = 0;
                }else{
                    s = s + 1;
                    w_snow.setVisibility(View.VISIBLE);

                    last.setVisibility(View.VISIBLE);
                    end.setVisibility(View.VISIBLE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,0 ,0,0);

                    LinearLayout.LayoutParams top = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    top.setMargins(0,10,0,0);
                    snow.setLayoutParams(lp);
                    w_snow.setLayoutParams(top);
                    snow.setText("눈이 왔어요.");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    snow.setTypeface(typeface);
                    snow.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 36);

                    son.setVisibility(View.GONE);
                    rain.setVisibility(View.GONE);
                    cloud.setVisibility(View.GONE);
                    bunge.setVisibility(View.GONE);
                    today_weather_two.setVisibility(View.GONE);
                    EventBus.getDefault().post(new SecondFragment.DataEvent(snow.getText().toString()));
                }
            }
        });
        bunge.setOnClickListener(new View.OnClickListener() {
            int s = 0;
            @Override
            public void onClick(View view) {
                if(s == 1){
                    w_bunge.setVisibility(View.GONE);

                    last.setVisibility(View.GONE);
                    end.setVisibility(View.GONE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,40 ,0,0);
                    bunge.setLayoutParams(lp);
                    bunge.setText("•번개가 쳤어요");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    bunge.setTypeface(typeface);
                    bunge.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 28);

                    son.setVisibility(View.VISIBLE);
                    cloud.setVisibility(View.VISIBLE);
                    rain.setVisibility(View.VISIBLE);
                    snow.setVisibility(View.VISIBLE);
                    today_weather_two.setVisibility(View.VISIBLE);
                    s = 0;
                }else{
                    s = s + 1;
                    w_bunge.setVisibility(View.VISIBLE);

                    last.setVisibility(View.VISIBLE);
                    end.setVisibility(View.VISIBLE);
                    LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    lp.setMargins(0,0 ,0,0);

                    LinearLayout.LayoutParams top = new LinearLayout.LayoutParams(
                            ViewGroup.LayoutParams.WRAP_CONTENT,
                            ViewGroup.LayoutParams.WRAP_CONTENT);
                    top.setMargins(0,10,0,0);
                    bunge.setLayoutParams(lp);
                    w_bunge.setLayoutParams(top);
                    bunge.setText("번개가 쳤어요.");
                    Typeface typeface = getResources().getFont(R.font.spoqa_han_sans_neo_bold);
                    bunge.setTypeface(typeface);
                    bunge.setTextSize(TypedValue.COMPLEX_UNIT_DIP, 36);

                    son.setVisibility(View.GONE);
                    rain.setVisibility(View.GONE);
                    cloud.setVisibility(View.GONE);
                    snow.setVisibility(View.GONE);
                    today_weather_two.setVisibility(View.GONE);
                    EventBus.getDefault().post(new SecondFragment.DataEvent(bunge.getText().toString()));
                }
            }
        });

//        spinner = (Spinner)view.findViewById(R.id.txt_question_type);
//        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(),android.R.layout.simple_spinner_dropdown_item, menu);
//        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
//        spinner.setAdapter(adapter);
//        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
//
//            @Override
//            public void onItemSelected(AdapterView<?> adapterView, View view, int position, long id) {
//                Toast.makeText(getActivity(),Integer.toString(position),Toast.LENGTH_SHORT); //본인이 원하는 작업.
//            }
//
//            @Override
//            public void onNothingSelected(AdapterView<?> adapterView) {
//
//            }
//        });

        return view;
    }


}
