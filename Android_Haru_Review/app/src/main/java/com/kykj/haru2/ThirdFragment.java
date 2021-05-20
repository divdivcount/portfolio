package com.kykj.haru2;

import android.content.Context;
import android.os.Bundle;
import androidx.fragment.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;

import org.greenrobot.eventbus.EventBus;

public class ThirdFragment extends Fragment {
    // Store instance variables
    private RatingBar q1,q2,q3;
    private String str1,str2,str3;

    public static class DataEvent {

        public final float startTotal;
        public final float startTotal2;
        public final float startTotal3;

        public DataEvent(float startTotal, float startTotal2, float startTotal3) {
            this.startTotal = startTotal;
            this.startTotal2 = startTotal2;
            this.startTotal3 = startTotal3;
        }
    }

    public void onDestroy(){
        super.onDestroy();
        EventBus.getDefault().unregister(this);
    }


    // newInstance constructor for creating fragment with arguments

    public static ThirdFragment newInstance(int page, String title) {
        ThirdFragment fragment = new ThirdFragment();
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
        View view = inflater.inflate(R.layout.fragment_third, container, false);
        q1 = (RatingBar)view.findViewById(R.id.q1);
        q2 = (RatingBar)view.findViewById(R.id.q2);
        q3 = (RatingBar)view.findViewById(R.id.q3);
        q1.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            @Override
            public void onRatingChanged(RatingBar ratingBar, float q1, boolean b) {
                str1 = String.valueOf(q1);
                str1 = Float.toString(q1);
                EventBus.getDefault().post(new ThirdFragment.DataEvent(q1,q2.getRating(),q3.getRating()));

            }
        });
        q2.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            @Override
            public void onRatingChanged(RatingBar ratingBar, float q2, boolean b) {
                str2 = String.valueOf(q2);
                str2 = Float.toString(q2);
                EventBus.getDefault().post(new ThirdFragment.DataEvent(q1.getRating(),q2,q3.getRating()));
            }
        });
        q3.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            @Override
            public void onRatingChanged(RatingBar ratingBar, float q3, boolean b) {
                str3 = String.valueOf(q3);
                str3 = Float.toString(q3);
                EventBus.getDefault().post(new ThirdFragment.DataEvent(q1.getRating(),q2.getRating(),q3));
            }
        });

        return view;
    }
}
