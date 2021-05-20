package com.kykj.haru2;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;
import java.util.regex.Pattern;
import android.text.Editable;
import android.text.Html;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import org.greenrobot.eventbus.EventBus;

import java.text.SimpleDateFormat;
import java.util.Date;

public class FirstFragment extends Fragment {
    // Store instance variables
    private String title;
    private int page;
    private EditText year;
    private LinearLayout focus;
    public static class DataEvent {

        public final String helloEventBus;

        public DataEvent(String helloEventBus) {
            this.helloEventBus = helloEventBus;
        }
    }
    public void onDestroy(){
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }
    // newInstance constructor for creating fragment with arguments
    public static FirstFragment newInstance(int page, String title) {
        FirstFragment fragment = new FirstFragment();
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

        if(getArguments() != null){
            title = getArguments().getString("someTitle");
        }else{
            System.out.println("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
        }

        View view = inflater.inflate(R.layout.fragment_first, container, false);
        year = (EditText) view.findViewById(R.id.year);

        focus = (LinearLayout)view.findViewById(R.id.focus);

        view.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {

                InputMethodManager imm = (InputMethodManager)getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(year.getWindowToken(), 0);
                return false;
            }
        });


        year.setText(title);
        String dataString = title;
        EventBus.getDefault().post(new DataEvent(dataString));
        onDestroy();
        year.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                year.setText("");
                year.setHint(Html.fromHtml("<small><small><small>"+title+" 형식이 같게 적어주세요"+"</small></small></small>"));
                return false;
            }
        });

        year.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence s, int i, int i1, int i2) {



            }

            @Override
            public void afterTextChanged(Editable editable) {
                String dataString = editable.toString();
                EventBus.getDefault().post(new DataEvent(dataString));
                onDestroy();
            }
        });


        return view;
    }


}
